@extends('layouts.app')

@section('title', 'メール認証')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class="verify-email-container">
    <div class="verify-email-content">
        <p class="verify-email-message">
            登録していただいたメールアドレスに認証メールを送付しました。<br>メール認証を完了してください。
        </p>

        @if (session('status') === 'verification-link-sent')
            <p class="verify-email-status">
                認証メールを再送しました
            </p>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" class="verify-email-form">
            @csrf
            <button type="submit" class="verify-email-button">
                認証はこちらから
            </button>
        </form>

        <form method="POST" action="{{ route('verification.send') }}" class="verify-email-logout-form">
            @csrf
            <button type="submit" class="verify-email-link">
                認証メールを再送する
            </button>
        </form>
    </div>
</div>
@endsection