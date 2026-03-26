<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'sell');

        $sellItems = Item::with(['categories', 'purchase'])->where('user_id', $user->id)->latest()->get();

        $buyItems = Item::with(['categories', 'purchase'])->whereHas('purchase', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->latest()->get();

        $likeItems = Item::with(['categories', 'purchase'])->whereHas('likes', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->latest()->get();

        return view('mypage', compact('user', 'page', 'sellItems', 'buyItems', 'likeItems'));
    }
}
