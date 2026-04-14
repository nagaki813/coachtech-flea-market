<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'フリマアプリ')</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header-inner">
            <div class="header-logo">
                <a href="{{ route('items.index') }}">COACHTECH</a>
            </div>

            <div class="header-search">
                <form action="{{ route('items.index') }}" method="GET" class="search-form">
                    <input type="text" name="keyword" class="search-form__input" value="{{ request('keyword') }}" placeholder="なにをお探しですか？">

                    @if (request('tab'))
                        <input type="hidden" name="tab" value="{{ request('tab') }}">
                    @endif
                </form>
            </div>

            <nav class="header-nav">
                <a href="{{ route('items.index') }}" class="header-nav__link {{ request()->routeIs('items.index') ? 'active' : '' }}">商品一覧</a>

                @auth
                    <a href="{{ route('mypage') }}" class="header-nav__link {{ request()->routeIs('mypage') ? 'active' : '' }}">マイページ</a>
                    <a href="{{ route('sell.create') }}" class="header-nav__sell-button">出品</a>
                    <form action="{{ route('logout') }}" method="POST" class="header-nav__logout-form">
                        @csrf
                        <button type="submit" class="header-nav__button">ログアウト</button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="header-nav__link">ログイン</a>
                    <a href="{{ route('register') }}" class="header-nav__link">会員登録</a>
                @endguest
            </nav>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>
</body>
</html>