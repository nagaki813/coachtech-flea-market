<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧</title>
</head>
<body>
    <h1>商品一覧</h1>

    @foreach ($items as $item)
    <div style="border:1px solid #ccc; margin-bottom: 10px; padding: 10px;">
        <h2>{{ $item->name }}</h2>
        <p>価格: {{ $item->price }}円</p>

        <p>カテゴリ:
            @foreach ($item->categories as $category)
                {{ $category->name }}
            @endforeach
        </p>
        <p>状態：{{ $item->purchase ? '売り切れ' : '販売中' }}</p>
        <p>いいね数： {{ $item->likes->count() }}</p>
        <a href="{{ route('items.show', $item->id) }}">詳細を見る</a>
    </div>
    @endforeach
</body>
</html>