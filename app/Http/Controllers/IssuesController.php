<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Validation\Rule;

class IssuesController extends Controller
{
    public function list (): \Inertia\Response
    {
        $issues = Issue::autoSearch('message')
            ->autoOrder()
            ->autoPaginate();

        return inertia('Dashboard/Issues/List', [
            'issues' => $issues,
        ]);
    }

    public function create() {
        $data = request()->validate([
            'project_id' => ['required', 'integer'],
            'http_code' => ['nullable', 'numeric', 'max:999'],
            'message' => ['nullable', 'string', 'max:255'],
            'stacktrace' => ['nullable', 'string'],
            'env' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'string', Rule::in(['warning', 'error'])],
            'triggered_at' => ['nullable', 'date'],
        ]);

        Issue::create([
            'project_id' => $data['project_id'],
            'http_code' => $data['http_code'],
            'message' => $data['message'],
            'stacktrace' => $data['stacktrace'],
            'type' => $data['type'],
            'env' => $data['env'] ?? null,
            'triggered_at' => $data['triggered_at'] ?? now(),
            'status' => 'new',
        ]);

        return response()->json([
            'state' => 'success',
        ]);
    }

    public function details(Issue $issue): \Inertia\Response
    {
        $currentUser = auth()->user();
        $users = $issue->users()
            ->orderBy('created_at', 'desc')
            ->get();
        $comments = $issue->comments()
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'issues_page');

        $issue->users = $users;
        $issue->comments = $comments;

        $userRole = $currentUser->getRoleInCompany($issue->project()->first()->company_id);
        $currentUser->canAssignUsers = $userRole != 'user';

        return inertia('Dashboard/Issues/Details', [
            'issue' => $issue,
            'currentUser' => $currentUser
        ]);
    }
}
