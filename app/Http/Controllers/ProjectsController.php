<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Company;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProjectsController extends Controller
{
    public function list (): \Inertia\Response
    {
        $currentUserId = auth()->user()->id;

        $projects = Project::whereHas('company.users', function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId)
                ->whereIn('role', ['admin', 'owner'])
                ->where('is_active', true);
        })->orWhereHas('users', function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId);
        })
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
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'issues_page');

        $project->users = $users;
        $project->issues = $issues;

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

        $project->users()->detach($userId);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => trans('toast.user_unassigned'),
        ]);
    }
}
