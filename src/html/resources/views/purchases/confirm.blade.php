@extends('layouts.app')

@section('title', '購入確認')

@section('content')
<div class="purchase-container">
    <h2>購入確認</h2>

    <div class="purchase-item">
        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" width="200">
        <p>{{ $item->name }}</p>
        <p>{{ number_format($item->price) }}円</p>
    </div>

    <form action="{{ route('purchases.store') }}" method="POST">
        @csrf
        <input type="hidden" name="item_id" value="{{ $item->id }}">
        <input type="hidden" name="payment_method" value="{{ $data['payment_method'] }}">
        <input type="hidden" name="postal_code" value="{{ $address['postal_code'] }}">
        <input type="hidden" name="address" value="{{ $address['address'] }}">
        <input type="hidden" name="building" value="{{ $address['building'] }}">

        <h3>支払方法</h3>
        <select name="payment_method">
            <option value="card">クレジットカード</option>
            <option value="bank">銀行振込</option>
            <option value="convenience">コンビニ</option>
        </select>

        <h3>配送先</h3>
        <p>{{ $address['postal_code'] }}</p>
        <p>{{ $address['address'] }}</p>
        <p>{{ $address['building'] }}</p>

        <a href="{{ route('purchases.address.edit', $item->id) }}">
            住所を変更する
        </a>

        <button type="submit">購入する</button>
    </form>
</div>
@endsection