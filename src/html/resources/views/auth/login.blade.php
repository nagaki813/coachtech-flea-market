@extends('layouts.app')

@section('title', 'ログイン')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="auth-container">
    <h2>ログイン</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="auth-form-group">
            <label>メールアドレス</label>
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

        <button class="auth-submit-button" type="submit">ログイン</button>
    </form>

    <div class="auth-link">
        <a href="{{ route('register') }}">会員登録はこちら</a>
    </div>
</div>
@endsection