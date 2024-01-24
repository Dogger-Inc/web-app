<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Company;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Services\QueryService;

class ProjectsController extends Controller
{
    public function list (QueryService $query): \Inertia\Response
    {
        $currentUserId = auth()->user()->id;
        $projects = Project::whereHas('users', function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId);
        });

        $projects = $query->search($projects, 'name');
        $projects = $query->order($projects);
        $projects = $query->paginate($projects);

        $companies = Company::whereHas('users', function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId);
        });
        $companies = $query->order($companies)->get();

        return inertia('Dashboard/Projects', [
            'projects' => $projects,
            'companies' => $companies,
        ]);
    }

    public function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('projects')],
            'company_id' => ['required', 'integer'],
        ]);

        $project = Project::create([
            'name' => $data['name'],
            'company_id' => $data['company_id'],
            'key' => strtoupper(Str::random(8)),
        ]);

        $project->users()->attach(auth()->user()->id);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Project created !',
        ]);
    }
}
