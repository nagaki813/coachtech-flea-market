<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:255',
        ]);

        Comment::create([
            'user_id' => auth()->id() ?? 1,
            'item_id' => $request->item_id,
            'content' => $request->content,
        ]);

        return redirect()->back();
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== 1) {
            abort(403);
        }

        $comment->delete();

        return redirect()->back();
    }
}
