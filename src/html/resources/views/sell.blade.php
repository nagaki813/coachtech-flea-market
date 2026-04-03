@extends('layouts.app')

@section('title', '出品')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell-container">
    <h2>商品を出品する</h2>

    <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="sell-form-row">
            <div class="sell-form-label">
                <label for="image">商品画像</label>
            </div>
            <div class="sell-form-input">
                <input id="image" type="file" name="image">
                @error('image')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="sell-form-row">
            <div class="sell-form-label">
                <label for="name">商品名</label>
            </div>
            <div class="sell-form-input">
                <input id="name" type="text" name="name" value="{{ old('name') }}">
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="sell-form-row">
            <div class="sell-form-label">
                <label for="brand_name">ブランド名</label>
            </div>
            <div class="sell-form-input">
                <input id="brand_name" type="text" name="brand_name" value="{{ old('brand_name') }}">
                @error('brand_name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="sell-form-row">
            <div class="sell-form-label">
                <label for="description">説明</label>
            </div>
            <div class="sell-form-input">
                <textarea id="description" name="description">{{ old('description') }}</textarea>
                @error('description')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="sell-form-row">
            <div class="sell-form-label">
                <label for="price">価格</label>
            </div>
            <div class="sell-form-input">
               <input id="price" type="number" name="price" value="{{ old('price') }}">
                @error('price')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="sell-form-row">
            <div class="sell-form-label">
                <label for="condition">状態</label>
            </div>
            <div class="sell-form-input">
                <select name="condition">
                    <option value="1" {{ old('condition') == 1 ? 'selected' : '' }}>良好</option>
                    <option value="2" {{ old('condition') == 2 ? 'selected' : '' }}>キズ、スレ有り</option>
                    <option value="3" {{ old('condition') == 3 ? 'selected' : '' }}>ジャンク品</option>
                </select>
                @error('condition')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="sell-form-row">
            <div class="sell-form-label">
                <label>カテゴリ</label>
            </div>
            <div class="sell-form-input">
                <div class="category-group">
                    @foreach ($categories as $category)
                        <label class="category-item">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
                        {{ $category->name }}
                        </label>
                    @endforeach
                </div>
                @error('categories')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button class="sell-submit-button" type="submit">出品する</button>
    </form>
</div>
@endsection