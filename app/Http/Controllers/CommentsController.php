<?php

namespace App\Http\Controllers;

use App\Models\Comment;

class CommentsController extends Controller
{
    public function editComment(Comment $comment) {
        $data = request()->validate([
            'content' => ['string'],
        ]);

        $comment->content = $data['content'];

        $comment->save();
    }
}
