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
        $user = auth()->user();
        $projects = $user->projects()->get();

        $groups = PerformanceGroup::whereBelongsTo($projects)
            ->autoSearch('message')
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

    public function assignUser(PerformanceGroup $performanceGroup) {
        $data = request()->validate([
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
        ]);

        if($performanceGroup->users()->where('user_id', $data['user_id'])->exists()) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'message' => 'User already assigned to performance !',
            ]);
        }

        $performanceGroup->users()->attach($data['user_id']);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'User assigned to performance !',
        ]);
    }

    public function unassignUser(PerformanceGroup $performanceGroup) {
        $data = request()->validate([
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
        ]);

        if($performanceGroup->users()->where('user_id', $data['user_id'])->doesntExist()) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'message' => 'User not assigned to performance !',
            ]);
        }

        $performanceGroup->users()->detach($data['user_id']);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'User unassigned from performance !',
        ]);
    }
}
