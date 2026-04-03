<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
        $data = [
            'user_id' => Auth::id(),
            'name' => $request->name,
            'brand_name' => $request->brand_name,
            'description' => $request->description,
            'price' => $request->price,
            'condition' => $request->condition,
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
            $data['image_path'] = $imagePath;
        }

        $item = Item::create($data);

        $item->categories()->attach($request->categories);

        return redirect('/mypage?page=sell');
    }
}
