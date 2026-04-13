<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class MyPageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'sell');

        $sellItems = Item::with(['categories', 'purchase'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(8, ['*'], 'sell_page');

        $buyItems = Item::with(['categories', 'purchase'])
            ->whereHas('purchase', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->paginate(8, ['*'], 'buy_page');

        $likeItems = Item::with(['categories', 'purchase'])
            ->whereHas('likes', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->paginate(8, ['*'], 'like_page');

        $sellItems->appends(['page' => 'sell']);
        $buyItems->appends(['page' => 'buy']);
        $likeItems->appends(['page' => 'like']);

        return view('mypage', compact(
            'user',
            'page',
            'sellItems',
            'buyItems',
            'likeItems'
        ));
    }
}
