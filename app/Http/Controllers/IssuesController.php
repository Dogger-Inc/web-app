<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\Validation\Rule;

class IssuesController extends Controller
{
    public function list (): \Inertia\Response
    {
        $currentUserId = auth()->user()->id;

        $projectsId = Project::retrieveRelevantProjects($currentUserId)->pluck('id')->toArray();

        $issues = Issue::whereIn('project_id', $projectsId)
            ->autoSearch('message')
            ->autoOrder()
            ->autoPaginate();

        return inertia('Dashboard/Issues/List', [
            'issues' => $issues,
        ]);
    }

    public function details(Issue $issue): \Inertia\Response
    {
        $this->authorize('view', $issue->project);

        $issue->load('project:id,name,company_id');
        $users = $issue->users()
            ->orderBy('created_at', 'desc')
            ->get();
        $comments = $issue->comments()
            ->with([
                'user',
                'replyTo' => function ($query) {
                    $query->with(['user']);
                }
            ])
            ->orderBy('created_at', 'asc')
            ->get();

        $issue->users = $users;
        $issue->comments = $comments;

        $currentUser = auth()->user();
        $currentUser->canUpdate = $currentUser->can('update', $issue->project->company);

        return inertia('Dashboard/Issues/Details', [
            'issue' => $issue,
            'currentUser' => $currentUser
        ]);
    }

    public function addComment(Issue $issue) {
        $this->authorize('view', $issue->project);

        $data = request()->validate([
            'reply_to' => ['nullable', 'integer', Rule::exists('users', 'id')],
            'content' => ['string'],
        ]);

        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'reply_to' => $data['reply_to'],
            'content' => $data['content'],
            'commentable_type' => 'issue',
            'commentable_id' => $issue->id,
        ]);

        $issue->comments()->save($comment);
    }

    public function assignUser(Issue $issue) {
        auth()->user()->can('update', $issue->project->company) || abort(403);

        $data = request()->validate([
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
        ]);

        if($issue->users()->where('user_id', $data['user_id'])->exists()) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'message' => trans('toast.user_already_assigned'),
            ]);
        }

        $issue->users()->attach($data['user_id']);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => trans('toast.user_assigned'),
        ]);
    }

    public function unassignUser(Issue $issue) {
        auth()->user()->can('update', $issue->project->company) || abort(403);

        $data = request()->validate([
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
        ]);

        if($issue->users()->where('user_id', $data['user_id'])->doesntExist()) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'message' => trans('toast.user_not_assigned'),
            ]);
        }

        $issue->users()->detach($data['user_id']);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => trans('toast.user_unassigned'),
        ]);
    }

    public function changeStatus(Issue $issue)
    {
        auth()->user()->can('update', $issue->project->company) || abort(403);

        $data = request()->validate([
            'status' => ['required', 'string', Rule::in(['new', 'pending', 'in_progress', 'resolved'])],
        ]);

        $issue->status = $data['status'];
        $issue->save();
    }
}
