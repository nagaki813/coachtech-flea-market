@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endsection

@section('content')
<div class="items-container">
    <div class="items-content">
        <div class="items-tab">
            <a href="{{ route('items.index', ['tab' => 'all']) }}"
                class="items-tab__link {{ $tab === 'all' ? 'active' : '' }}">おすすめ
            </a>

            <a href="{{ route('items.index', ['tab' => 'mylist']) }}"
                class="items-tab__link {{ $tab === 'mylist' ? 'active' : '' }}">マイリスト
            </a>
        </div>

        <div class="items-list">
            @forelse ($items as $item)
                <div class="item-card">
                    <a class="item-card__link" href="{{ route('items.show', ['item' => $item->id]) }}">
                        <div class="item-card__image-wrapper">
                            @if (!empty($item->image_path))
                                <img class="item-card__image" src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                            @else
                                <div class="item-card__image--empty">画像無し</div>
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
            @empty
                <p class="items-empty">商品がありません。</p>
            @endforelse
        </div>
    </div>
</div>
@endsection