<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入履歴</title>
</head>
<body>
    <h1>購入履歴</h1>

    @if ($purchases->isEmpty())
        <p>購入履歴はありません。</p>
    @else
        @foreach ($purchases as $purchase)
            <div style="border:1px solid #ccc; margin-bottom:10px; padding:10px;">
                <h2>{{ $purchase->item->name }}</h2>
                <p>価格：{{ $purchase->item->price }}円</p>
                <p>購入日：{{ $purchase->created_at }}</p>
            </div>
        @endforeach
    @endif

    <a href="{{ route('items.index') }}">一覧へ戻る</a>
</body>
</html>