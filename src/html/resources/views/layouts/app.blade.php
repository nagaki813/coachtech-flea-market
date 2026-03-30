<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'フリマアプリ')</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header-inner">
            <h1 class="header-logo">フリマアプリ</h1>

            <nav class="header-nav">
                <a href="/">商品一覧</a>
                <a href="{{ route('mypage') }}">マイページ</a>
                <a href="{{ route('sell.create') }}">出品</a>

                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">ログアウト</button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}">ログイン</a>
                    <a href="{{ route('register') }}">会員登録</a>
                @endguest
            </nav>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>
</body>
</html>