<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseAddressRequest;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('item')
            ->where('user_id', auth()->id())
            ->get();

        return view('purchases.index', compact('purchases'));
    }

    public function store(StorePurchaseRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $item = Item::with('purchase')->findOrFail($data['item_id']);

        if ($item->purchase) {
            return redirect()->back()->with('error', 'この商品はすでに売り切れです。');
        }

        Purchase::create([
            'user_id' => $data['user_id'],
            'item_id' => $item->id,
            'payment_method' => $data['payment_method'],
            'postal_code' => $data['postal_code'],
            'address' => $data['address'],
            'building' => $data['building'] ?? null,
        ]);

        session()->forget('purchase_address');

        return redirect()->route('mypage', ['page' => 'buy'])->with('success', '購入しました');
    }

    public function create($item_id)
    {
        $item = Item::with('user', 'purchase')->findOrFail($item_id);

        if ($item->purchase) {
            return redirect()->back()->with('error', 'この商品は売り切れです');
        }

        $address = $this->getPurchaseAddress();

        return view('purchases.confirm', compact('item', 'address'));
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $address = $this->getPurchaseAddress();

        return view('purchases.address', compact('item', 'address'));
    }

    public function updateAddress(UpdatePurchaseAddressRequest $request, $item_id)
    {
        $data = $request->validated();

        session(['purchase_address' => [
            'postal_code' => $data['postal_code'],
            'address' => $data['address'],
            'building' => $data['building'] ?? null,
        ]]);

        return redirect()->route('purchases.create', $item_id);
    }

    private function getPurchaseAddress(): array
    {
        return session('purchase_address') ?? [
            'postal_code' => auth()->user()->postal_code,
            'address' => auth()->user()->address,
            'building' => auth()->user()->building,
        ];
    }
}
