@extends('layouts.app')

@section('title', 'プロフィール編集')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-edit-container">
    <h2>プロフィール編集</h2>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="profile-form-group">
            <label for="profile_image">プロフィール画像</label>
            <input id="profile_image" type="file" name="profile_image">
            @error('profile_image')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-form-group">
            <label for="name">ユーザー名</label>
            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-form-group">
            <label for="postal_code">郵便番号</label>
            <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" >
            @error('postal_code')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-form-group">
            <label for="address">住所</label>
            <input id="address" type="text" name="address" value="{{ old('address', $user->address) }}">
            @error('address')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-form-group">
            <label for="building">建物名</label>
            <input id="building" type="text" name="building" value="{{ old('building', $user->building) }}">
            @error('building')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button class="profile-submit-button" type="submit">更新する</button>
    </form>
</div>
@endsection