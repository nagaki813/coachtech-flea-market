@extends('layouts.app')

@section('title', '商品詳細')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item-detail.css') }}">
@endsection

@section('content')
<div class="detail-container">
    <h2 class="page-title">商品詳細</h2>

    <div class="detail-card">
        <div class="detail-image-area">
            @if (!empty($item->image_path))
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" width="250">
            @else
                <div class="detail-image detail-image--empty">画像無し</div>
            @endif
        </div>

        <div class="detail-info-area">
            <h3>{{ $item->name }}</h3>
            <p><strong>商品名：</strong>{{ $item->name }}</p>
            <p><strong>ブランド名：</strong>{{ $item->brand_name ?? '未設定' }}</p>
            <p><strong>説明：</strong>{{ $item->description }}</p>
            <p><strong>価格：</strong>{{ number_format($item->price) }}円</p>
            <p><strong>カテゴリ：</strong></p>

            <ul class="category-list">
                @foreach ($item->categories as $category)
                    <li>{{ $category->name }}</li>
                @endforeach
            </ul>

            <p><strong>売り切れ状態：</strong>{{ $item->purchase ? '売り切れ' : '販売中' }}</p>

        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if (session('error'))
            <p class="error-message">{{ session('error') }}</p>
        @endif

        @if (!$item->purchase)
            @auth
                <form class="inline-form" action="{{ route('purchases.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <button type="submit">購入する</button>
                </form>
            @else
                <p>購入するにはログインしてください</p>
            @endauth
        @else
            <p class="sold-text">この商品はすでに売り切れです。</p>
        @endif

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
    </div>

    <div class="comment-area">
        <form action="/comment" method="POST">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <textarea class="comment-textarea" name="content"></textarea>
            @error('content')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <button class="main-button" type="submit">コメントする</button>
        </form>

        <h3>コメント一覧</h3>
        <p>コメント数：{{ $item->comments->count() }}</p>

        @if ($item->comments->isEmpty())
            <p>コメントはまだありません。</p>
        @else
            @foreach ($item->comments as $comment)
                <div class="comment-card">
                    <p>投稿者: {{ $comment->user->name }}</p>
                    <p>{{ $comment->content }}</p>
                    @if ($comment->user_id === auth()->id())
                        <form class="inline-form" action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="sub-button" type="submit">削除</button>
                        </form>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    <div class="page-links">
        <a href="{{ route('items.index') }}">一覧に戻る</a>
    </div>
</div>
@endsection