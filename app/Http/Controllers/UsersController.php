<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;

class UsersController extends Controller
{
    public function search(Project $project): \Illuminate\Http\JsonResponse
    {
        $data = request()->validate([
            'property' => ['required', 'string'],
            'search' => ['string'],
        ]);

        $users = User::whereHas('projects', function ($query) use ($project) {
            $query->where('project_id', $project->id);
        })
            ->where($data['property'], 'LIKE', "%". $data['search'] ."%")
            ->get();

        return response()->json($users);
    }
}
