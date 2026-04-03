<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request)
    {
        $data = [
            'user_id' => Auth::id(),
            'item_id' => $request->item_id,
            'comment' => $request->comment,
        ];

        Comment::create($data);

        return redirect()->back();
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();

        return redirect()->back();
    }
}
