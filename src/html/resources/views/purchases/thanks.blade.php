@extends('layouts.app')

@section('title', '購入完了')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase-thanks.css') }}">
@endsection

@section('content')
<div class="purchase-thanks-container">
    <div class="purchase-thanks-content">
        <p class="purchase-thanks-message">購入が完了しました</p>

        <a href="{{ route('items.index') }}" class="purchase-thanks-button">
            商品一覧へ戻る
        </a>
    </div>
</div>
@endsection