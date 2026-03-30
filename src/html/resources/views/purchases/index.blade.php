@extends('layouts.app')

@section('title', '購入履歴')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endsection

@section('content')
<div class="items-container">
    <h2 class="page-title">購入履歴</h2>

    @if ($purchases->isEmpty())
        <p>購入履歴はありません。</p>
    @else
        <div class="item-grid">
            @foreach ($purchases as $purchase)
                <div class="item-card">
                    @if(!empty($purchase->item->image_path))
                        <img class="item-card-image" src="{{ asset('storage/' . $purchase->item->image_path) }}" alt="{{ $purchase->item->name }}">
                    @else
                        <div class="item-card-image item-card-image--empty">画像なし</div>
                    @endif

                    <h3 class="item-card-title">{{ $purchase->item->name }}</h3>
                    <p>価格：{{ number_format($purchase->item->price) }}円</p>
                    <p>購入日：{{ $purchase->created_at }}</p>
                </div>
            @endforeach
        </div>
    @endif

    <div class="page-links">
        <a href="{{ route('items.index') }}">一覧へ戻る</a>
    </div>
</div>
@endsection