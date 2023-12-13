<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Services\QueryService;

class CompaniesController extends Controller
{
    public function list (QueryService $query): \Inertia\Response
    {
        $currentUserId = auth()->user()->id;
        $companies = Company::whereHas('users', function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId);
        });

        $companies = $query->search($companies, 'name');
        $companies = $query->order($companies);
        $companies = $query->paginate($companies);

        return inertia('Dashboard/Companies/List', [
            'companies' => $companies,
        ]);
    }

    public function details(Company $company): \Inertia\Response
    {
        // for advanced query purpose we need to load users and projects separately
        $users = $company->users()
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'users_page');
        $projects = $company->projects()
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'projects_page');

        $company->users = $users;
        $company->projects = $projects;

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
            'message' => 'Company created !',
        ]);
    }

    public function join(Company $company) {

        $user = auth()->user();

        if($user && $company->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'message' => 'You are already in this company !',
            ]);
        }

        $company->users()->attach($user->id, ['role' => 'user']);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Company joined !',
        ]); 
    }
}
