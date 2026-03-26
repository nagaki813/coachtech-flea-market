@extends('layouts.app')

@section('title', 'マイページ')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="mypage-container">
        <h2>マイページ</h2>

        <div class="mypage-profile">
            <p>ユーザー名：{{ $user->name }}</p>
            <p>メールアドレス：{{ $user->email }}</p>
            <p>郵便番号：{{ $user->postal_code ?? '未設定' }}</p>
            <p>住所：{{ $user->address ?? '未設定' }}</p>
            <p>建物名：{{ $user->building ?? '未設定' }}</p>

            @if (!empty($user->profile_image))
                <div>
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" width="120">
                </div>
            @else
                <p>プロフィール画像：未設定</p>
            @endif
        </div>

        <div class="mypage-pages">
            <a href="{{ route('mypage', ['page' => 'sell']) }}">出品した商品</a>
            <a href="{{ route('mypage', ['page' => 'buy']) }}">購入した商品</a>
            <a href="{{ route('mypage', ['page' => 'like']) }}">いいねした商品</a>
        </div>

        @if ($page === 'sell')
            <h3>出品した商品一覧</h3>

            @if ($sellItems->isEmpty())
                <p>出品した商品はありません。</p>
            @else
                <div class="item-list">
                    @foreach ($sellItems as $item)
                        <div class="item-card">
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" width="120">
                            <h4>{{ $item->name }}</h4>
                            <p>価格：￥{{ number_format($item->price) }}</p>

                            <p>
                                カテゴリ：
                                @foreach ($item->categories as $category)
                                {{ $category->name }}
                                    @if (!$loop->last)
                                        /
                                    @endif
                                @endforeach
                            </p>

                            @if ($item->purchase)
                                <p>売り切れ</p>
                            @else
                                <p>出品中</p>
                            @endif

                            <a href="{{ route('items.show', $item->id) }}">詳細を見る</a>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        @if ($page === 'buy')
            <h3>購入した商品一覧</h3>

            @if ($buyItems->isEmpty())
                <p>購入した商品はありません。</p>
            @else
                <div class="item-list">
                    @foreach ($buyItems as $item)
                        <div class="item-card">
                         <h4>{{ $item->name }}</h4>
                         <p>価格：￥{{ number_format($item->price) }}</p>

                            <p>
                                カテゴリ：
                                @foreach ($item->categories as $category)
                                    {{ $category->name }}
                                    @if (!$loop->last)
                                        /
                                    @endif
                                @endforeach
                            </p>

                            <p>売り切れ</p>

                            <a href="{{ route('items.show', $item->id) }}">詳細を見る</a>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        @if ($page === 'like')
            <h3>いいねした商品一覧</h3>

            @if ($likeItems->isEmpty())
                <p>いいねした商品はありません。</p>
            @else
                <div class="item-list">
                    @foreach ($likeItems as $item)
                     <div class="item-card">
                            <h4>{{ $item->name }}</h4>
                            <p>価格：￥{{ number_format($item->price) }}</p>

                            <p>
                                カテゴリ：
                                @foreach ($item->categories as $category)
                                    {{ $category->name }}
                                    @if (!$loop->last)
                                        /
                                    @endif
                                @endforeach
                            </p>

                            @if ($item->purchase)
                                <p>売り切れ</p>
                            @else
                                <p>出品中</p>
                            @endif

                            <a href="{{ route('items.show', $item->id) }}">詳細を見る</a>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
@endsection