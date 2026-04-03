@extends('layouts.app')

@section('title', '住所変更')

@section('content')
<div class="address-container">
    <h2>配送先住所の変更</h2>

    <form action="{{ route('purchases.address.update', $item->id) }}" method="POST">
        @csrf

        <div>
            <label>郵便番号</label>
            <input type="text" name="postal_code" value="{{ $address['postal_code'] }}">
        </div>

        <div>
            <label>住所</label>
            <input type="text" name="address" value="{{ $address['address'] }}">
        </div>

        <div>
            <label>建物名</label>
            <input type="text" name="building" value="{{ $address['building'] }}">
        </div>

        <button type="submit">更新する</button>
    </form>
</div>
@endsection