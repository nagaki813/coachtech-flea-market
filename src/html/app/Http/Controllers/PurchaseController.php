<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $purchases = Purchase::with('item')->where('user_id', $userId)->get();

        return view('purchases.index', compact('purchases'));
    }

    public function store(Request $request)
    {
        $item = Item::with('purchase')->findOrFail($request->item_id);

        if ($item->purchase) {
            return redirect()->back()->with('error', 'この商品はすでに売り切れです。');
        }

        Purchase::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'payment_method' => $request->payment_method,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        session()->forget('purchase_address');

        return redirect('/mypage?page=buy')->with('success', '購入しました');
    }

    public function create($item_id)
    {
        $item = Item::with('user', 'purchase')->findOrFail($item_id);

        if ($item->purchase) {
            return redirect()->back()->with('error', 'この商品は売り切れです');
        }

        $address = session('purchase_address') ?? [
            'postal_code' => auth()->user()->postal_code,
            'address' => auth()->user()->address,
            'building' => auth()->user()->building,
        ];

        return view('purchases.confirm', compact('item', 'address'));
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);

        $address = session('purchase_address') ?? [
            'postal_code' => auth()->user()->postal_code,
            'address' => auth()->user()->address,
            'building' => auth()->user()->building,
        ];

        return view('purchases.address', compact('item', 'address'));
    }

    public function updateAddress(Request $request, $item_id)
    {
        $data = [
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ];

        session(['purchase_address' => $data]);

        return redirect()->route('purchases.create', $item_id);
    }
}
