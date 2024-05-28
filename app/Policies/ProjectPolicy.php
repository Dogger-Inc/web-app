<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can view the project.
     */
    public function view(User $user, Project $project): Response
    {
        $userIsInProject = $project->users()->where('user_id', $user->id)->exists();
        $userIsAdminOrOwner = $user->companies()->where('company_id', $project->company_id)->wherePivotIn('role', ['admin', 'owner'])->exists();

        return $userIsInProject || $userIsAdminOrOwner
            ? Response::allow()
            : Response::deny();
    }
}
