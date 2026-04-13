@extends('layouts.app')

@section('title', 'マイページ')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="mypage-container">
        <div class="mypage-profile">
            <div class="profile-left">
                @if (!empty($user->profile_image))
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像">
                @else
                    <div class="profile-placeholder"></div>
                @endif
            </div>

            <div class="profile-center">
                <h3 class="profile-name">{{ $user->name }}</h3>
            </div>

            <div class="profile-right">
                <a class="profile-edit-link" href="{{ route('profile.edit') }}">
                    プロフィールを編集
                </a>
            </div>
        </div>

        <div class="mypage-pages">
            <a href="{{ route('mypage', ['page' => 'sell']) }}"
                class="{{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
            <a href="{{ route('mypage', ['page' => 'buy']) }}"
                class="{{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
{{--            <a href="{{ route('mypage', ['page' => 'like']) }}"
                class="{{ $page === 'like' ? 'active' : '' }}">いいねした商品</a> --}}
        </div>

        @if ($page === 'sell')
            <div class="item-list">
                @forelse ($sellItems as $item)
                    <div class="item-card">
                        @if (!empty($item->image_path))
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                        @else
                            <div class="image-placeholder"></div>
                        @endif

                        <p class="item-name">{{ $item->name }}</p>
                    </div>
                @empty
                    <p class="empty-message">出品した商品はありません。</p>
                @endforelse
            </div>
        @endif

        @if ($page === 'buy')
            <div class="item-list">
                @forelse ($buyItems as $item)
                    <div class="item-card">
                        @if (!empty($item->image_path))
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                        @else
                            <div class="image-placeholder"></div>
                        @endif
                            <p class="item-name">{{ $item->name }}</p>
                    </div>
                @empty
                    <p class="empty-message">購入した商品はありません。</p>
                @endforelse
            </div>
            <div class="pagination-wrap">
                {{ $buyItems->links() }}
            </div>
        @endif

        @if ($page === 'like')
            <div class="item-list">
                @forelse ($likeItems as $item)
                    <div class="item-card">
                        @if (!empty($item->image_path))
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                        @else
                            <div class="image-placeholder"></div>
                        @endif
                            <p class="item-name">{{ $item->name }}</p>
                    </div>
                @empty
                    <p class="empty-message">いいねした商品はありません。</p>
                @endforelse
            </div>
            <div class="pagination-wrap">
                {{ $likeItems->links() }}
            </div>
        @endif
    </div>
@endsection