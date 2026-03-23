<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品詳細</title>
</head>
<body>
    <h1>商品詳細</h1>

    <div style="border:1px solid #ccc; padding:10ppx;">
        <h2>{{ $item->name }}</h2>
        <p><strong>商品名：</strong>{{ $item->name }}</p>
        <p><strong>ブランド名：</strong>{{ $item->brand_name ?? '未設定' }}</p>
        <p><strong>説明：</strong>{{ $item->description }}</p>
        <p><strong>価格：</strong>{{ $item->price }}円</p>
        <p><strong>カテゴリ：</strong></p>
        <ul>
            @foreach ($item->categories as $category)
                <li>{{ $category->name }}</li>
            @endforeach
        </ul>

        <p><strong>売り切れ状態：</strong>{{ $item->purchase ? '売り切れ' : '販売中' }}</p>
        <p>いいね数： {{ $item->likes->count() }}</p>

        <h3>コメント一覧</h3>

        @if ($item->comments->isEmpty())
            <p>コメントはまだありません。</p>
        @else
            @foreach ($item->comments as $comment)
                <div style="border:1px solid #ddd; margin-bottom:10px; padding:10px;">
                    <p>投稿者: {{ $comment->user->name }}</p>
                    <p>{{ $comment->content }}</p>
                </div>
            @endforeach
        @endif
    </div>

    <p>
        <a href="{{ route('items.index') }}">一覧に戻る</a>
    </p>
</body>
</html>