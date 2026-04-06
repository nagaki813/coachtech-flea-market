@extends('layouts.app')

@section('title', '商品詳細')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="detail-container">
    <div class="detail-card">
        <div class="detail-image-area">
            @if (!empty($item->image_path))
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
            @else
                <div class="detail-image detail-image--empty">画像無し</div>
            @endif
        </div>

        <div class="detail-info-area">
            <h2 class="item-name">{{ $item->name }}</h2>
            <p class="item-brand">{{ $item->brand_name ?? 'ブランド名なし' }}</p>
            <p class="item-price">¥{{ number_format($item->price) }}</p>

            <div class="item-meta">
                <div class="meta-item">
                    <span class="icon-like">♡</span>
                    <span class="meta-count">{{ $item->likes->count() }}</span>
                </div>
                <div class="meta-item">
                    <span class="icon-comment">💬</span>
                    <span class="meta-count">{{ $item->comments->count() }}</span>
                </div>
            </div>

            @if (session('success'))
                <p class="success-message">{{ session('success') }}</p>
            @endif

            @if (session('error'))
                <p class="error-message">{{ session('error') }}</p>
            @endif

            @if (!$item->purchase)
                @auth
                    <a class="main-button" href="{{ route('purchases.create', $item->id) }}">購入手続きへ</a>
                @else
                    <p class="notice-text">購入するにはログインしてください</p>
                @endauth
            @else
                <p class="sold-text">この商品はすでに売り切れです。</p>
            @endif

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
                <p class="notice-text">いいねするにはログインしてください</p>
            @endauth

            <div class="item-section">
                <h3>商品説明</h3>
                <p>{{ $item->description }}</p>
            </div>

            <div class="item-section">
                <h3>商品の情報</h3>
                <p><strong>カテゴリー：</strong></p>
                <ul class="category-list">
                    @foreach ($item->categories as $category)
                        <li>{{ $category->name }}</li>
                    @endforeach
                </ul>
                <p><strong>商品の状態：</strong>{{ $item->condition_label }}</p>
            </div>

            <div class="comment-area">
                <h3 class="meta-count">コメント({{ $item->comments->count() }})</h3>
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <textarea class="comment-textarea" name="content">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                    <button class="main-button" type="submit">コメントする</button>
                </form>

                @if ($item->comments->isEmpty())
                    <p>コメントはまだありません。</p>
                @else
                    @foreach ($item->comments as $comment)
                        <div class="comment-card">
                            <p class="comment-user">投稿者: {{ $comment->user->name }}</p>
                            <p>{{ $comment->content }}</p>

                            @auth
                                @if ($comment->user_id === auth()->id())
                                    <form class="inline-form" action="{{ route('comments.destroy',  $comment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="sub-button" type="submit">削除</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection