<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if(file_exists(public_path('css/mypage.css')))
        <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
    @endif
</head>
<body>
    <div class="mypage-container">
        <h2>マイページ</h2>

        <div class="mypage-profile">
            <p>ユーザー名：{{ $user->name }}</p>
            <p>メールアドレス：{{ $user->email }}</p>
        </div>

        <div class="mypage-pages">
            <a href="{{ route('mypage', ['page' => 'sell']) }}">出品した商品</a>
            <a href="{{ route('mypage', ['page' => 'buy']) }}">購入した商品</a>
        </div>

        @if ($page === 'sell')
            <h3>出品した商品一覧</h3>

            @if ($sellItems->isEmpty())
                <p>出品した商品はありません。</p>
            @else
                <div class="item-list">
                    @foreach ($sellItems as $item)
                        <div class="item-card">
                            <h4>{{ $item->name }}</h4>
                            <p>価格：￥{{ number_format($item->price) }}</p>

                            <p>
                                カテゴリ：
                                @foreach ($item->categories as $category)
                                {{ $category->name }}
                                    @if (!$loop->last)
                                        /
                                    @endif
                                @endforeach
                            </p>

                            @if ($item->purchase)
                                <p>売り切れ</p>
                            @else
                                <p>出品中</p>
                            @endif
                            
                            <a href="{{ route('items.show', $item->id) }}">詳細を見る</a>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        @if ($page === 'buy')
            <h3>購入した商品一覧</h3>

            @if ($buyItems->isEmpty())
                <p>購入した商品はありません。</p>
            @else
                <div class="item-list">
                    @foreach ($buyItems as $item)
                        <div class="item-card">
                         <h4>{{ $item->name }}</h4>
                         <p>価格：￥{{ number_format($item->price) }}</p>

                            <p>
                                カテゴリ：
                                @foreach ($item->categories as $category)
                                    {{ $category->name }}
                                    @if (!$loop->last)
                                        /
                                    @endif
                                @endforeach
                            </p>

                            <p>売り切れ</p>

                            <a href="{{ route('items.show', $item->id) }}">詳細を見る</a>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
</body>
</html>