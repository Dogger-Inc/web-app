<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompanyPolicy
{
    private function userIsInCompany(User $user, Company $company): bool
    {
        return $user->companies()->where('company_id', $company->id)->exists();
    }

    private function userIsActive(User $user, Company $company): bool
    {
        return $user->companies()->where('company_id', $company->id)->wherePivot('is_active', true)->exists();
    }

    private function userIsAdminOrOwner(User $user, Company $company): bool
    {
        return $user->companies()->where('company_id', $company->id)->wherePivotIn('role', ['admin', 'owner'])->exists();
    }

    /**
     * Determine whether the user can view the company.
     */
    public function view(User $user, Company $company): Response
    {
        return $this->userIsInCompany($user, $company)
            ? Response::allow()
            : Response::deny();
    }

    /**
     * Determine whether the user can view the details (projects, users, etc.) of the company.
     */
    public function viewDetails(User $user, Company $company): bool
    {
        return $this->userIsActive($user, $company);
    }

    /**
     * Determine whether the user can update the company.
     */
    public function update(User $user, Company $company): bool
    {
        return $this->userIsActive($user, $company) && $this->userIsAdminOrOwner($user, $company);
    }
}
