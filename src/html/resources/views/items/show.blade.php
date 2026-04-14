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
                    @auth
                        <form class="like-icon-form" action="{{ route('likes.toggle') }}" method="POST">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">

                            <button type="submit" class="meta-icon like-icon-button {{ $item->likes->where('user_id', auth()->id())->isNotEmpty() ? 'liked' : '' }}">
                                {{ $item->likes->where('user_id', auth()->id())->isNotEmpty() ? '♥' : '♡' }}
                            </button>
                        </form>
                    @else
                        <span class="meta-icon">♡</span>
                    @endauth

                    <span class="meta-count">{{ $item->likes->count() }}</span>
                </div>

                <div class="meta-item">
                    <span class="meta-icon">💬</span>
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

            <div class="item-section">
                <h3>商品説明</h3>
                <p class="item-description">{{ $item->description }}</p>
            </div>

            <div class="item-section">
                <h3>商品の情報</h3>
                <div class="info-row">
                    <p class="info-label">カテゴリー</p>
                    <ul class="category-list">
                        @foreach ($item->categories as $category)
                            <li>{{ $category->name }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="info-row">
                    <p class="info-label">商品の状態</p>
                    <p class="info-value">{{ $item->condition_label }}</p>
                </div>
            </div>

            <div class="comment-area">
                <h3>コメント({{ $item->comments->count() }})</h3>
                @if ($item->comments->isEmpty())
                    <p class="empty-comment-text">コメントはまだありません。</p>
                @else
                    @foreach ($item->comments as $comment)
                        <div class="comment-card">
                            <div class="comment-header">
                                <div class="comment-avatar"></div>
                                <p class="comment-user">{{ $comment->user->name }}</p>
                            </div>
                            <p class="comment-body">{{ $comment->content }}</p>

                            @auth
                                @if ($comment->user_id === auth()->id())
                                    <form class="inline-form comment-delete-form" action="{{ route('comments.destroy',  $comment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="sub-button" type="submit">削除</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                @endif
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <textarea class="comment-textarea" name="content">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                    <button class="main-button" type="submit">コメントする</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection