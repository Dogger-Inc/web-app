<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Company;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProjectsController extends Controller
{
    public function list (): \Inertia\Response
    {
        $currentUserId = auth()->user()->id;

        $projects = Project::retrieveRelevantProjects($currentUserId)
            ->autoSearch('name')
            ->autoOrder()
            ->autoPaginate();

        // get companies for new project form
        $companies = Company::whereHas('users', function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId)->where('is_active', true);
        })
            ->with(['users' => function ($query) {
                $query->select('id', 'firstname', 'lastname')
                    ->wherePivot('is_active', true);
            }])
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);

        return inertia('Dashboard/Projects/List', [
            'projects' => $projects,
            'companies' => $companies,
        ]);
    }

    public function details(Project $project): \Inertia\Response
    {
        $user = auth()->user();
        $this->authorize('view', $project);
        $project->editable = $user->can('update', $project->company);

        $assignableUsers = $project->company->users()
            ->wherePivot('is_active', true)
            ->whereNotIn('id', $project->users()->pluck('id'))
            ->get(['id', 'firstname', 'lastname']);

        $users = $project->users()
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'users_page');
        $issues = $project->issues()
            ->orderByRaw("FIELD(status, 'new', 'pending', 'in_progress', 'resolved')")
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'issues_page');

        $performanceGroups = $project->performanceGroups()
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'performance_groups_page');

        $project->users = $users;
        $project->issues = $issues;
        $project->performanceGroups = $performanceGroups;

        return inertia('Dashboard/Projects/Details', [
            'project' => $project,
            'assignableUsers' => $assignableUsers
        ]);
    }

    public function store(): \Illuminate\Http\RedirectResponse
    {
        $assignableUsers = User::whereHas('companies', function ($query) {
            $query->where('company_id', request()->company_id)->where('is_active', true);
        })->get(['id'])->pluck('id')->toArray();

        $data = request()->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('projects')],
            'company_id' => ['required', 'integer', Rule::exists('companies', 'id')],
            'users' => ['nullable', 'array'],
            'users.*' => ['integer', 'distinct', Rule::in($assignableUsers)]
        ]);

        auth()->user()->can('update', Company::find($data['company_id'])) || abort(403);

        $project = Project::create([
            'name' => $data['name'],
            'company_id' => $data['company_id'],
            'key' => strtoupper(Str::random(16)),
        ]);

        $project->users()->attach($data['users'] ?? []);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => trans('toast.project_created'),
        ]);
    }

    public function refresh_code(Project $project): \Illuminate\Http\RedirectResponse
    {
        auth()->user()->can('update', $project->company) || abort(403);

        $project->key = strtoupper(Str::random(16));
        $project->save();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => trans('toast.invitation_code_updated'),
        ]);
    }

    public function update(Project $project): \Illuminate\Http\RedirectResponse
    {
        auth()->user()->can('update', $project->company) || abort(403);

        $data = request()->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('projects')->ignore($project->id)],
        ]);

        $project->name = $data['name'];
        $project->save();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => trans('toast.project_updated'),
        ]);
    }

    public function assignUsers(Project $project): \Illuminate\Http\RedirectResponse
    {
        auth()->user()->can('update', $project->company) || abort(403);

        $assignableUsers = $project->company->users()
            ->wherePivot('is_active', true)
            ->whereNotIn('id', $project->users()->pluck('id'))
            ->get(['id'])->pluck('id')->toArray();

        $data = request()->validate([
            'users' => ['required', 'array'],
            'users.*' => ['integer', 'distinct', Rule::in($assignableUsers)]
        ]);

        $project->users()->attach($data['users']);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => trans('toast.user_assigned'),
        ]);
    }

    public function unassignUser(Project $project, int $userId): \Illuminate\Http\RedirectResponse
    {
        auth()->user()->can('update', $project->company) || abort(403);

        DB::transaction(function () use ($project, $userId) {
            // detach user from all issues and performanceGroups in project
            $project->issues()->each(function ($issue) use ($userId) {
                $issue->users()->detach($userId);
            });
            $project->performanceGroups()->each(function ($performanceGroup) use ($userId) {
                $performanceGroup->users()->detach($userId);
            });

            // detach user from project
            $project->users()->detach($userId);
        });


        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => trans('toast.user_unassigned'),
        ]);
    }
}
