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

        return inertia('Dashboard/Companies', [
            'companies' => $companies,
        ]);
    }

    public function store() {
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
}
