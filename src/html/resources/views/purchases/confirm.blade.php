@extends('layouts.app')

@section('title', '購入確認')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase-confirm.css') }}">
@endsection

@section('content')
<div class="purchase-confirm-container">
    <form action="{{ route('purchases.store') }}" method="POST" class="purchase-confirm-form">
        @csrf
        <input type="hidden" name="item_id" value="{{ $item->id }}">
        <input type="hidden" name="postal_code" value="{{ $address['postal_code'] }}">
        <input type="hidden" name="address" value="{{ $address['address'] }}">
        <input type="hidden" name="building" value="{{ $address['building'] }}">

        <div class="purchase-confirm-content">
            <div class="purchase-confirm-left">
                <div class="purchase-item-card">
                    <div class="purchase-item-image">
                        @if (!empty($item->image_path))
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                        @else
                            <div class="purchase-item-image--empty"></div>
                        @endif
                    </div>

                    <div class="purchase-item-info">
                        <h2 class="purchase-item-name">{{ $item->name }}</h2>
                        <p class="purchase-item-price">¥{{ number_format($item->price) }}</p>
                    </div>
                </div>

                <div class="purchase-section">
                    <h3 class="purchase-section-title">支払い方法</h3>

                    <div class="purchase-section-body">
                        <select name="payment_method" id="payment_method" class="purchase-select">
                            <option value="">選択してください</option>
                            <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>クレジットカード</option>
                            <option value="bank" {{ old('payment_method') === 'bank' ? 'selected' : '' }}>銀行振込</option>
                            <option value="convenience" {{ old('payment_method') === 'convenience' ? 'selected' : '' }}>コンビニ払い</option>
                        </select>

                        @error('payment_method')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="purchase-section">
                    <div class="purchase-address-header">
                        <h3 class="purchase-section-title">配送先</h3>
                        <a href="{{ route('purchases.address.edit', $item->id) }}" class="purchase-address-link">
                            変更する
                        </a>
                    </div>

                    <div class="purchase-section-body purchase-address-body">
                        <p>〒{{ $address['postal_code'] }}</p>
                        <p>{{ $address['address'] }}</p>
                        @if (!empty($address['building']))
                            <p>{{ $address['building'] }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="purchase-confirm-right">
                <div class="purchase-summary">
                    <div class="purchase-summary-row">
                        <span>商品代金</span>
                        <span>¥{{ number_format($item->price) }}</span>
                    </div>

                    <div class="purchase-summary-row">
                        <span>支払い方法</span>
                        <span class="purchase-summary-note" id="payment-method-display">
                            @if (old('payment_method') === 'card')
                                クレジットカード
                            @elseif (old('payment_method') === 'bank')
                                銀行振込
                            @elseif (old('payment_method') === 'convenience')
                                コンビニ払い
                            @else
                                選択してください
                            @endif
                        </span>
                    </div>
                </div>

                <button type="submit" class="purchase-submit-button">購入する</button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethodSelect = document.getElementById('payment_method');
        const paymentMethodDisplay = document.getElementById('payment-method-display');

        function updatePaymentMethodDisplay() {
            const selectedText = paymentMethodSelect.options[paymentMethodSelect.selectedIndex].text;
            const selectedValue = paymentMethodSelect.value;

            console.log('value:', selectedValue);
            console.log('text:', selectedText);

            if (selectedValue=== '') {
                paymentMethodDisplay.textContent = '選択してください';
            } else {
                paymentMethodDisplay.textContent = selectedText;
            }
        }

        paymentMethodSelect.addEventListener('change', updatePaymentMethodDisplay);

        updatePaymentMethodDisplay();
    });
</script>
@endsection