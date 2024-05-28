<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CompaniesController extends Controller
{
    public function list (): \Inertia\Response
    {
        $currentUserId = auth()->user()->id;

        $companies = Company::whereHas('users', function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId);
        })
            ->autoSearch('name')
            ->autoOrder()
            ->autoPaginate();

        return inertia('Dashboard/Companies/List', [
            'companies' => $companies,
        ]);
    }

    public function details(Company $company): \Inertia\Response
    {
        $user = auth()->user();
        $this->authorize('view', $company);

        // check if user is active in company
        $company->is_hidden = !$user->can('viewDetails', $company);

        if (!$company->is_hidden) {
            $company->editable = $user->can('update', $company);

            // for advanced query purpose we need to load users and projects separately
            $inactiveUsers = $company->users()
                ->orderBy('created_at', 'desc')
                ->wherePivot('is_active', false)
                ->paginate(10, ['*'], 'users_disabled_page');
            $activeUsers = $company->users()
                ->orderBy('created_at', 'desc')
                ->wherePivot('is_active', true)
                ->paginate(10, ['*'], 'users_active_page');
            $projects = $company->projects()
                ->when(!$company->editable, function ($query) use ($user) {
                    $query->whereHas('users', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], 'projects_page');

            $company->inactiveUsers = $inactiveUsers;
            $company->activeUsers = $activeUsers;
            $company->projects = $projects;
        }

        return inertia('Dashboard/Companies/Details', [
            'company' => $company,
        ]);
    }

    public function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('companies')],
        ]);

        $company = Company::create([
            'name' => $data['name'],
            'key' => strtoupper(Str::random(8)),
        ]);

        $company->users()->attach(auth()->user()->id, ['role' => 'owner', 'is_active' => true]);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => trans('toast.company_created'),
        ]);
    }

    public function refresh_code(Company $company): \Illuminate\Http\RedirectResponse
    {
        auth()->user()->can('update', $company) || abort(403);

        $company->key = strtoupper(Str::random(8));
        $company->save();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => trans('toast.invitation_code_updated'),
        ]);
    }

    public function join(Company $company): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();

        if($user && $user->companies()->where('company_id', $company->id)->exists()) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'message' => trans('toast.already_in_company'),
            ]);
        }

        $company->users()->attach($user->id, ['role' => 'user']);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => trans('toast.company_joined'),
        ]);
    }

    public function reject(Company $company, int $userId): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();
        $user->can('update', $company) || abort(403);

        if ($user->id == $userId) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'message' => trans('toast.cant_revoke_yourself'),
            ]);
        }

        $company->users()->detach($userId);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => trans('toast.user_revoked'),
        ]);
    }

    public function accept(Company $company, int $userId): \Illuminate\Http\RedirectResponse
    {
        auth()->user()->can('update', $company) || abort(403);

        $company->users()->updateExistingPivot($userId, ['is_active' => true]);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => trans('toast.user_accepted'),
        ]);
    }
}
