@extends('layouts.app')

@section('title', '会員登録')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}"> 
@endsection

@section('content')
<div class="auth-container">
    <h2>会員登録</h2>
    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <div class="auth-form-group">
            <label for="name">ユーザー名</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="auth-form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}">
            @error('email')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="auth-form-group">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password">
            @error('password')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="auth-form-group">
            <label for="password_confirmation">確認用パスワード</label>
            <input id="password_confirmation" type="password" name="password_confirmation">
        </div>
        <button class="auth-submit-button" type="submit">登録する</button>
    </form>
    <div class="auth-link">
        <a href="{{ route('login') }}">ログインはこちら</a>
    </div>
</div>
@endsection