<?php

namespace App\Http\Controllers;

use App\Models\Performance;

class PerformancesController extends Controller
{
    public function create() {
        $data = request()->validate([
            'project_id' => ['required', 'integer'],
            'duration' => ['nullable', 'numeric'],
            'comment' => ['nullable', 'string', 'max:255'],
        ]);

        Performance::create([
            'project_id' => $data['project_id'],
            'duration' => $data['duration'],
            'comment' => $data['comment'],
        ]);

        return response()->json([
            'state' => 'success',
        ]);
    }
}
