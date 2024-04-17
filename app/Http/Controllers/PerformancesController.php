<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Performance;
use App\Models\PerformanceGroup;
use Illuminate\Validation\Rule;

class PerformancesController extends Controller
{
    public function list (): \Inertia\Response
    {
        $groups = PerformanceGroup::autoSearch('message')
            ->autoOrder()
            ->autoPaginate();

        return inertia('Dashboard/Performances/List', [
            'performanceGroups' => $groups,
        ]);
    }

    public function create() {
        $data = request()->validate([
            'project_id' => ['required', 'integer'],
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

    public function details(String $groupKey): \Inertia\Response
    {
        $currentUser = auth()->user();
        $performanceGroup = PerformanceGroup::where('key', '=', $groupKey)->first();
        $performances = $performanceGroup->performances()->get();

        $users = $performanceGroup->users()
            ->orderBy('created_at', 'desc')
            ->get();
        $comments = $performanceGroup->comments()
            ->with([
                'user',
                'replyTo' => function ($query) {
                    $query->with(['user']);
                }
            ])
            ->orderBy('created_at', 'asc')
            ->get();

        $performanceGroup->users = $users;
        $performanceGroup->comments = $comments;

        $userRole = $currentUser->getRoleInCompany($performanceGroup->project()->first()->company_id);
        $currentUser->canAssignUsers = $userRole != 'user';

        return inertia('Dashboard/Performances/Details', [
            'group' => $performanceGroup,
            'performances' => $performances,
            'currentUser' => $currentUser
        ]);
    }

    public function addComment(PerformanceGroup $performanceGroup) {
        $data = request()->validate([
            'reply_to' => ['nullable', 'integer', Rule::exists('comments', 'id')],
            'content' => ['string'],
        ]);

        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'reply_to' => $data['reply_to'],
            'content' => $data['content'],
            'commentable_type' => 'issue',
            'commentable_id' => $performanceGroup->id,
        ]);

        $performanceGroup->comments()->save($comment);
    }
}
