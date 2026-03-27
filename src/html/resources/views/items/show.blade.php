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
        @if (!empty($item->image_path))
            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" width="250">
        @else
            <p>画像無し</p>
        @endif
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

        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if (session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        @if (!$item->purchase)
            @auth
                <form action="{{ route('purchases.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <button type="submit">購入する</button>
                </form>
            @else
                <p>購入するにはログインしてください</p>
            @endauth
        @else
            <p style="color: red;">この商品はすでに売り切れです。</p>
        @endif

        <p>いいね数： {{ $item->likes->count() }}</p>

        @auth
            <form action="{{ route('likes.toggle') }}" method="POST">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">

                @if ($item->likes->where('user_id', auth()->id())->isNotEmpty())
                    <button type="submit">いいね解除</button>
                @else
                    <button type="submit">いいねする</button>
                @endif
            </form>
        @else
            <p>いいねするにはログインしてください</p>
        @endauth

        <form action="/comment" method="POST">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <textarea name="content"></textarea>
            @error('content')
                <p style="color:red;">{{ $message }}</p>
            @enderror
            <button type="submit">コメントする</button>
        </form>

        <h3>コメント一覧</h3>
        <p>コメント数：{{ $item->comments->count() }}</p>

        @if ($item->comments->isEmpty())
            <p>コメントはまだありません。</p>
        @else
            @foreach ($item->comments as $comment)
                <div style="border:1px solid #ddd; margin-bottom:10px; padding:10px;">
                    <p>投稿者: {{ $comment->user->name }}</p>
                    <p>{{ $comment->content }}</p>
                    @if ($comment->user_id === auth()->id())
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">削除</button>
                        </form>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    <p>
        <a href="{{ route('items.index') }}">一覧に戻る</a>
    </p>
</body>
</html>