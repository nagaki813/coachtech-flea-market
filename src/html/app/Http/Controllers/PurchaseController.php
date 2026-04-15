<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseAddressRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

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

        $item = Item::with('purchase')->findOrFail($data['item_id']);

        if ($item->purchase) {
            return redirect()->back()->with('error', 'この商品はすでに売り切れです。');
        }

        if ($data['payment_method'] === 'convenience' && $item->price < 120) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'コンビニ支払いは120円以上の商品でのみ利用できます。');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentMethodTypes = match ($data['payment_method']) {
            'card' => ['card'],
            'convenience' => ['konbini'],
            'default' => ['card'],
        };

        session([
            'checkout_purchase' => [
                'user_id' => auth()->id(),
                'item_id' => $item->id,
                'payment_method' => $data['payment_method'],
                'postal_code' => $data['postal_code'],
                'address' => $data['address'],
                'building' => $data['building'] ?? null,
            ]
        ]);

        $checkoutSession = StripeSession::create([
            'mode' => 'payment',
            'payment_method_types' => $paymentMethodTypes,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => (int) $item->price,
                ],
                'quantity' => 1,
            ]],
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('purchases.create', $item->id),
        ]);

        return redirect($checkoutSession->url);
    }

    public function stripeSuccess(Request $request)
    {
        $data = session('checkout_purchase');

        if (!$data) {
            return redirect()->route('items.index')->with('error', '購入情報がありません');
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $stripeSession = StripeSession::retrieve($request->query('session_id'));

        if ($stripeSession->payment_status !== 'paid') {
            return redirect()->route('purchases.create', $data['item_id'])
                ->with('error', '決済が完了していません');
        }

        $alreadyPurchased = Purchase::where('item_id', $data['item_id'])->exists();

        if (!$alreadyPurchased) {
            Purchase::create([
                'user_id' => $data['user_id'],
                'item_id' => $data['item_id'],
                'payment_method' => $data['payment_method'],
                'postal_code' => $data['postal_code'],
                'address' => $data['address'],
                'building' => $data['building'],
            ]);
        }

        session()->forget('checkout_purchase');
        session()->forget('purchase_address');

        return redirect()->route('purchases.thanks');
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

    public function thanks()
    {
        return view('purchases.thanks');
    }
}