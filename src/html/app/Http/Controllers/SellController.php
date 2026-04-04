<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\StoreItemRequest;

class SellController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('sell', compact('categories'));
    }

    public function store(StoreItemRequest $request)
    {
        $data = $request->validated();

        $itemData = [
            'user_id' => auth()->id(),
            'name' => $data['name'],
            'brand_name' => $data['brand_name'] ?? null,
            'description' => $data['description'],
            'price' => $data['price'],
            'condition' => $data['condition'],
        ];

        if ($request->hasFile('image')) {
            $itemData['image_path'] = $request->file('image')->store('items', 'public');
        }

        $item = Item::create($itemData);

        $item->categories()->attach($data['categories']);

        return redirect()->route('mypage', ['page' => 'sell']);
    }
}
