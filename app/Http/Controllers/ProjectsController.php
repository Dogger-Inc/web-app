<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\QueryService;

class ProjectsController extends Controller
{
    public function list (QueryService $query): \Inertia\Response
    {
        $currentUserId = auth()->user()->id;
        $projects = Project::whereHas('users', function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId);
        });

        return inertia('Dashboard/Projects', [
            'projects' => $projects,
        ]);
    }
}
