<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'all');

        if ($tab === 'mylist') {
            if(!auth()->check()) {
                return redirect()->route('login');
            }

            $items = Item::with(['user', 'categories', 'purchase', 'likes'])->whereHas('likes', function ($query) {
                $query->where('user_id', auth()->id());
            })->latest()->get();
        } else {
            $items = Item::with(['user', 'categories', 'likes', 'purchase'])->latest()->get();
        }

        return view('items.index', compact('items', 'tab'));
    }

    public function show(Item $item)
    {
        $item->load('categories', 'comments.user', 'likes', 'purchase');

        return view('items.show', compact('item'));
    }
}
