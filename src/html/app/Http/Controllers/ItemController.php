<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'all');
        $keyword = trim((string) $request->query('keyword', ''));

        $query = Item::with(['user', 'categories', 'purchase', 'likes']);

        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        if ($keyword !== '') {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        if ($tab === 'mylist') {
            if(auth()->check()) {
                $query->whereHas('likes', function ($query) {
                    $query->where('user_id', auth()->id());
                });
            } else {
                $query->whereRaw('0 = 1');
            }
        }

        $items = $query->latest()
            ->paginate(8)
            ->appends([
            'tab' => $tab,
            'keyword' => $keyword,
        ]);

        return view('items.index', compact('items', 'tab', 'keyword'));
    }

    public function show(Item $item)
    {
        $item->load('categories', 'comments.user', 'likes', 'purchase');

        return view('items.show', compact('item'));
    }
}
