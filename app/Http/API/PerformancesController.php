<?php

namespace App\Http\API\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Performance;
use App\Models\PerformanceGroup;
use Illuminate\Validation\Rule;

class PerformancesController extends Controller
{
    public function create() {
        $data = request()->validate([
            'project_id' => ['required', 'integer', Rule::exists('projects', 'id')],
            'duration' => ['nullable', 'numeric'],
            'comment' => ['nullable', 'string', 'max:255'],
            'env' => ['nullable', 'string', 'max:255'],
        ]);

        $performanceGroup = PerformanceGroup::where('key', '=', $data['comment'])
            ->where('project_id', '=', $data['project_id'])->first();

        if (!$performanceGroup) {
            $performanceGroup = PerformanceGroup::create([
                'project_id' => $data['project_id'],
                'key' => $data['comment'],
                'env' => $data['env'],
            ]);
        }

        Performance::create([
            'group_id' => $performanceGroup->id,
            'duration' => $data['duration'],
            'comment' => $data['comment'],
        ]);

        return response()->json([
            'state' => 'success',
        ]);
    }
}
