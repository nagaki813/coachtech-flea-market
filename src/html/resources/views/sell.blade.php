@extends('layouts.app')

@section('title', '出品')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell-container">
    <h2>商品の出品</h2>

    <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="sell-section">
            <h3 class="sell-section-title">商品画像</h3>
            <div class="sell-image-upload">
                <input id="image" type="file" name="image" hidden>
                <label for="image" class="image-upload-button">画像を選択する</label>
            </div>
            @error('image')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="sell-section">
            <h3 class="sell-section-title">商品の詳細</h3>

            <div class="sell-form-row">
                <div class="sell-form-label">
                    <label>カテゴリー</label>
                </div>
                <div class="sell-form-input">
                    <div class="category-group">
                        @foreach ($categories as $category)
                            <label class="category-item">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
                                <span>{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('categories')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="sell-form-row">
                <div class="sell-form-label">
                    <label for="condition">商品の状態</label>
                </div>
                <div class="sell-form-input">
                    <select name="condition" id="condition">
                        <option value="" disabled {{ old('condition') ? '' : 'selected' }}>選択してください</option>
                        <option value="1" {{ old('condition') == 1 ? 'selected' : '' }}>良好</option>
                        <option value="2" {{ old('condition') == 2 ? 'selected' : '' }}>目立った傷や汚れ無し</option>
                        <option value="3" {{ old('condition') == 3 ? 'selected' : '' }}>やや傷や汚れあり</option>
                        <option value="4" {{ old('condition') == 4 ? 'selected' : '' }}>状態が悪い</option>
                    </select>
                    @error('condition')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="sell-section">
            <h3 class="sell-section-title">商品名と説明</h3>

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
                    <label for="description">商品の説明</label>
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
                    <label for="price">販売価格</label>
                </div>
                <div class="sell-form-input">
                    <div class="price-input-wrap">
                        <span class="price-yen">¥</span>
                        <input id="price" type="number" name="price" value="{{ old('price') }}">
                    </div>
                    @error('price')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <button class="sell-submit-button" type="submit">出品する</button>
    </form>
</div>
@endsection