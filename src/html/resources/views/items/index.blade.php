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
        <h2>
            <a href="{{ route('items.show', $item->id) }}">{{ $item->name }}</a>
        </h2>

        <p>価格: {{ $item->price }}円</p>

        <p>カテゴリ:
            @foreach ($item->categories as $category)
                {{ $category->name }}
            @endforeach
        </p>
        <p>状態：{{ $item->purchase ? '売り切れ' : '販売中' }}</p>
        <p>いいね数： {{ $item->likes->count() }}</p>
        <form action="{{ route('likes.toggle') }}" method="POST">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">

            @if ($item->likes->where('user_id', 1)->isNotEmpty())
                <button type="submit">いいね解除</button>
            @else
                <button type="submit">いいねする</button>
            @endif
        </form>

        @if (!$item->purchase)
            <form action="{{ route('purchases.store') }}" method="POST">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <button type="submit">購入する</button>
            </form>
        @else
            <p style="color: red;">売り切れ</p>
        @endif

        <a href="{{ route('items.show', $item->id) }}">詳細を見る</a>
    </div>
    @endforeach
</body>
</html>