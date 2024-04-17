<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Company;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProjectsController extends Controller
{
    public function list (): \Inertia\Response
    {
        $currentUserId = auth()->user()->id;

        $projects = Project::whereHas('users', function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId);
        })
            ->autoSearch('name')
            ->autoOrder()
            ->autoPaginate();

        $companies = Company::whereHas('users', function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId);
        })
            ->orderBy('name', 'asc')
            ->get();

        return inertia('Dashboard/Projects/List', [
            'projects' => $projects,
            'companies' => $companies,
        ]);
    }

    public function details(Project $project): \Inertia\Response
    {
        // for advanced query purpose we need to load users and projects separately
        $user = auth()->user();
        $users = $project->users()
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'users_page');
        $issues = $project->issues()
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'issues_page');

        $userRole = $user->getRoleInCompany($project->company_id);
        $project->editable = $userRole != 'user';

        $project->users = $users;
        $project->issues = $issues;

        return inertia('Dashboard/Projects/Details', [
            'project' => $project,
        ]);
    }

    public function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('projects')],
            'company_id' => ['required', 'integer', Rule::exists('companies', 'id')],
        ]);

        $project = Project::create([
            'name' => $data['name'],
            'company_id' => $data['company_id'],
            'key' => strtoupper(Str::random(16)),
        ]);

        $project->users()->attach(auth()->user()->id);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Project created !',
        ]);
    }

    public function refresh_code(Project $project): \Illuminate\Http\RedirectResponse
    {
        $project->key = strtoupper(Str::random(16));

        $project->save();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Invitation code updated !',
        ]);
    }

    public function update(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'project_id' => ['required', 'integer', Rule::exists('projects', 'id')],
            'name' => ['required', 'string', 'max:100', Rule::unique('projects')],
        ]);

        $project = Project::find($data['project_id']);

        $project->name = $data['name'];

        $project->save();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Project updated !',
        ]);
    }
}
