@extends('layouts.app')

@section('title', '送付先住所変更')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase-address.css') }}">
@endsection

@section('content')
<div class="purchase-address-container">
    <div class="purchase-address-content">
        <h2 class="purchase-address-title">住所の変更</h2>
        <form action="{{ route('purchases.address.update', $item->id) }}" method="POST" class="purchase-address-form">
            @csrf

            <div class="purchase-address-form__group">
                <label for="postal_code" class="purchase-address-form__label">郵便番号</label>
                <input id="postal_code" type="text" name="postal_code" class="purchase-address-form__input" value="{{ old('postal_code', $address['postal_code']) }}">
                @error('postal_code')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="purchase-address-form__group">
                <label for="address" class="purchase-address-form__label">住所</label>
                <input type="text" name="address" class="purchase-address-form__input" value="{{ old('address', $address['address']) }}">
                @error('address')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="purchase-address-form__group">
                <label for="building" class="purchase-address-form__label">建物名</label>
                <input id="building" type="text" name="building" class="purchase-address-form__input" value="{{ old('building', $address['building']) }}">
                @error('building')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="purchase-address-form__button">更新する</button>
        </form>
    </div>
</div>
@endsection