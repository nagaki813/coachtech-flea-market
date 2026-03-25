<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $userId = auth()->id();

        $like = Like::where('user_id', $userId)
            ->where('item_id', $request->item_id)
            ->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => $userId,
                'item_id' => $request->item_id,
            ]);
        }

        return redirect()->back();
    }
}
