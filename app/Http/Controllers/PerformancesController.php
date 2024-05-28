<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Project;
use App\Models\PerformanceGroup;
use Illuminate\Validation\Rule;

class PerformancesController extends Controller
{
    public function list (): \Inertia\Response
    {
        $currentUserId = auth()->user()->id;

        $projectsId = Project::retrieveRelevantProjects($currentUserId)->pluck('id')->toArray();

        $groups = PerformanceGroup::whereIn('project_id', $projectsId)
            ->autoSearch('message')
            ->autoOrder()
            ->autoPaginate();

        return inertia('Dashboard/Performances/List', [
            'performanceGroups' => $groups,
        ]);
    }

    public function details(PerformanceGroup $performanceGroup): \Inertia\Response
    {
        $this->authorize('view', $performanceGroup->project);

        $performanceGroup->load('project:id,name');
        $performances = $performanceGroup->performances()->get();

        $users = $performanceGroup->users()
            ->orderBy('created_at', 'desc')
            ->get();
        $comments = $performanceGroup->comments()
            ->with(['user', 'replyTo.user'])
            ->orderBy('created_at', 'asc')
            ->get();

        $performanceGroup->users = $users;
        $performanceGroup->comments = $comments;

        $currentUser = auth()->user();
        $currentUser->canUpdate = $currentUser->can('update', $performanceGroup->project->company);

        return inertia('Dashboard/Performances/Details', [
            'group' => $performanceGroup,
            'performances' => $performances,
            'currentUser' => $currentUser
        ]);
    }

    public function addComment(PerformanceGroup $performanceGroup) {
        $this->authorize('view', $performanceGroup->project);

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
        auth()->user()->can('update', $performanceGroup->project->company) || abort(403);

        $data = request()->validate([
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
        ]);

        if($performanceGroup->users()->where('user_id', $data['user_id'])->exists()) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'message' => trans('toast.user_already_assigned'),
            ]);
        }

        $performanceGroup->users()->attach($data['user_id']);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => trans('toast.user_assigned'),
        ]);
    }

    public function unassignUser(PerformanceGroup $performanceGroup) {
        auth()->user()->can('update', $performanceGroup->project->company) || abort(403);

        $data = request()->validate([
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
        ]);

        if($performanceGroup->users()->where('user_id', $data['user_id'])->doesntExist()) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'message' => trans('toast.user_not_assigned'),
            ]);
        }

        $performanceGroup->users()->detach($data['user_id']);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => trans('toast.user_unassigned'),
        ]);
    }
}
