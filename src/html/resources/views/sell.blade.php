@extends('layouts.app')

@section('title', '出品')

@section('content')
<div class="sell-container">
    <h2>商品を出品する</h2>

    <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>商品画像</label>
            <input type="file" name="image">
        </div>

        <div>
            <label>商品名</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div>
            <label>ブランド名</label>
            <input type="text" name="brand_name" value="{{ old('brand_name') }}">
        </div>

        <div>
            <label>説明</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>

        <div>
            <label>価格</label>
            <input type="number" name="price" value="{{ old('b
            price') }}">
        </div>

        <div>
            <label>状態</label>
            <select name="condition">
                <option value="1" {{ old('condition') == 1 ? 'selected' : '' }}>良好</option>
                <option value="2" {{ old('condition') == 2 ? 'selected' : '' }}>キズ、スレ有り</option>
                <option value="3" {{ old('condition') == 3 'selected' : '' }}>ジャンク品</option>
            </select>
        </div>

        <div>
            <label>カテゴリ</label>
            @foreach ($categories as $category)
                <label>
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
                    {{ $category->name }}
                </label>
            @endforeach
        </div>

        <button type="submit">出品する</button>
    </form>
</div>
@endsection