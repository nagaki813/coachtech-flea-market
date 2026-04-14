@extends('layouts.app')

@section('title', 'プロフィール編集')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-edit-container">
    <div class="profile-edit-content">
        <h2 class="profile-edit-title">プロフィール設定</h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="profile-image-section">
                <div class="profile-image-preview">
                    @if (!empty($user->profile_image))
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像">
                    @else
                        <div class="profile-image-placeholder"></div>
                    @endif
                </div>

                <div class="profile-image-input-wrap">
                    <label for="profile_image" class="profile-image-select-button">画像を選択する</label>
                    <input id="profile_image" type="file" name="profile_image" class="profile-image-input">
                    @error('profile_image')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="profile-form-group">
                <label for="name" class="profile-form-label">ユーザー名</label>
                <input id="name" type="text" name="name" class="profile-form-input" value="{{ old('name', $user->name) }}">
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-form-group">
                <label for="postal_code" class="profile-form-label">郵便番号</label>
                <input id="postal_code" type="text" name="postal_code" class="profile-form-input" value="{{ old('postal_code', $user->postal_code) }}" >
                @error('postal_code')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-form-group">
                <label for="address" class="profile-form-label">住所</label>
                <input id="address" type="text" name="address" class="profile-form-input" value="{{ old('address', $user->address) }}">
                @error('address')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-form-group">
                <label for="building" class="profile-form-label">建物名</label>
                <input id="building" type="text" name="building" class="profile-form-input" value="{{ old('building', $user->building) }}">
                @error('building')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

        <button class="profile-submit-button" type="submit">更新する</button>
    </form>
</div>
@endsection