@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endsection

@section('content')
<div class="items-container">
    <h2 class="items-container">商品一覧</h2>

    <div class="item-grid">
        @foreach ($items as $item)
            <div class="item-card">
                @if (!empty($item->image_path))
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" width="150">
                @else
                    <div class="item-card-image item-card-image--empty">画像無し</div>
                @endif

                <h3 class="item-card-title">
                    <a href="{{ route('items.show', $item->id) }}">{{ $item->name }}</a>
                </h3>

                <p>価格：{{ number_format($item->price) }}円</p>
                <p>
                    カテゴリ:
                    @foreach ($item->categories as $category)
                        {{ $category->name }}
                    @endforeach
                </p>
                <p>状態：{{ $item->purchase ? '売り切れ' : '販売中' }}</p>
                <p>いいね数： {{ $item->likes->count() }}</p>

                @auth
                    <form class="inline-form" action="{{ route('likes.toggle') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        @if ($item->likes->where('user_id', auth()->id())->isNotEmpty())
                            <button class="sub-button" type="submit">いいね解除</button>
                        @else
                            <button class="sub-button" type="submit">いいねする</button>
                        @endif
                    </form>
                @else
                    <p>いいねするにはログインしてください</p>
                @endauth

                @if (!$item->purchase)
                    @auth
                        <form class="inline-form" action="{{ route('purchases.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <button class="main-button" type="submit">購入する</button>
                        </form>
                    @else
                        <p>購入するにはログインしてください</p>
                    @endauth
                @else
                    <p class="sold-text">売り切れ</p>
                @endif

                <a href="{{ route('items.show', $item->id) }}">詳細を見る</a>
            </div>
        @endforeach
    </div>

    <div class="page-links">
        <a href="{{ route('purchases.index') }}">購入履歴を見る</a>
    </div>

    @auth
        <form action="/logout" method="POST">
            @csrf
            <button type="submit">ログアウト</button>
        </form>
    @endauth
</div>
@endsection