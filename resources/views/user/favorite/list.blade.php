<html>
    <head>

    </head>
    <body>
        <div class="container">
            <h2>お気に入り商品一覧</h2>
            @if($favorites->isEmpty())
                <p>お気に入り商品はありません。</p>
            @else
                <div class="favorite-products">
                    @foreach($favorites as $favorite)
                        @if($favorite->product)
                            <div class="favorite-item">
                                <a href="{{ route('products.show', $favorite->product->id) }}">
                                    <img src="{{ asset('storage/' . $favorite->product->image_path) }}" alt="{{ $favorite->product->name }}" width="150">
                                    <p>{{ $favorite->product->name }}</p>
                                    <p>¥{{ number_format($favorite->product->price) }}</p>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </body>
</html>