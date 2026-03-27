<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Category;

class SellController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('sell', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|max:255',
            'brand_name' => 'nullable|max:255',
            'description' => 'required|max:1000',
            'price' => 'required|integer|min:0',
            'condition' => 'required|integer',
            'categories' => 'required|array',
        ]);

        $imagePath = $request->file('image')->store('items', 'public');

        $item = Item::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'brand_name' => $request->brand_name,
            'description' => $request->description,
            'price' => $request->price,
            'condition' => $request->condition,
            'image_path' => $request->file('image')->store('items', 'public'),
            'is_sold' => false,
        ]);

        $item->categories()->attach($request->categories);

        return redirect('/mypage?page=sell');
    }
}
