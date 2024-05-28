<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    private function userIsInProject(User $user, Project $project): bool
    {
        return $project->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can view the project.
     */
    public function view(User $user, Project $project): Response
    {
        return $this->userIsInProject($user, $project)
            ? Response::allow()
            : Response::deny();
    }
}
