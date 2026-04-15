@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endsection

@section('content')
<div class="items-container">
    <div class="items-content">
        <div class="items-tab">
            <a href="{{ route('items.index', ['tab' => 'all', 'keyword' => $keyword]) }}" class="items-tab__link {{ $tab === 'all' ? 'active' : '' }}">おすすめ
            </a>

            <a href="{{ route('items.index', ['tab' => 'mylist', 'keyword' => $keyword]) }}" class="items-tab__link {{ $tab === 'mylist' ? 'active' : '' }}">マイリスト
            </a>
        </div>

        @if ($items->isEmpty())
            <p class="items-empty">商品がありません。</p>
            @if ($tab === 'mylist' && !auth()->check())
                <p class="empty-message">マイリストを表示するにはログインが必要です。</p>
            @endif
        @else
            <div class="items-list">
                @foreach ($items as $item)
                    <div class="item-card">
                        <a class="item-card__link" href="{{ route('items.show', ['item' => $item->id]) }}">
                            <div class="item-card__image-wrapper">
                                @if (!empty($item->image_path))
                                    <img class="item-card__image" src="{{ \Illuminate\Support\Str::startsWith($item->image_path, ['http://', 'https://']) ? $item->image_path : asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                                @else
                                    <div class="item-card__image--empty"></div>
                                @endif

                                @if ($item->purchase)
                                    <span class="item-card__sold">Sold</span>
                                @endif
                            </div>

                            <div class="item-card__body">
                                <p class="item-card__name">{{ $item->name }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="pagination-wrap">
                {{ $items->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection