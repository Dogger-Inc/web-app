<?php

namespace App\Http\API\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use Illuminate\Validation\Rule;

class IssuesController extends Controller
{
    public function create() {
        $data = request()->validate([
            'project_id' => ['required', 'integer', Rule::exists('projects', 'id')],
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
}
