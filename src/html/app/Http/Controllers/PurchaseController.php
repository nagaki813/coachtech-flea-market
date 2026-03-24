<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function store(Request $request)
    {
        $item = Item::with('purchase')->findOrFail($request->item_id);

        if ($item->purchase) {
            return redirect()->back()->with('error', 'この商品はすでに売り切れです。');
        }

        Purchase::create([
            'user_id' => 1, // 仮
            'item_id' => $item->id,
            'payment_method' => 'コンビニ払い', // 仮
            'postal_code' => '000-0000', // 仮
            'address' => '仮住所', // 仮
            'building' => null,
        ]);

        return redirect()->route('items.show', $item->id)->with('success', '購入が完了しました。');
    }
}
