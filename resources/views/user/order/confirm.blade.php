<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>apparelECsite</title>
    </head>
    <body>
        @if (session('error'))
            <div>
                {{ session('error') }}
            </div>
        @endif
        <h2>注文内容確認</h2>
        <p>配送先住所: {{ $shippingAddress }}</p>
        <p>支払い方法: {{ $paymentMethodLabel }}</p>
        @if ($coupon)
            <p>クーポン適用: {{ $coupon->code }} (¥{{ number_format($discount) }} 割引)</p>
        @endif
        <ul>
            @foreach ($cartItems as $item)
                <li style="margin-bottom: 20px;">
                <img src="{{ asset('storage/' . $item->variant->product_images->first()->image_path) }}" alt="商品画像">
                    <div>
                        <strong>{{ $item->variant->product->name }}</strong><br>
                        色: {{ $item->variant->product_color->name}}<br>
                        サイズ: {{ $item->variant->product_size->name }}<br>
                        数量: {{ $item->quantity }}<br>
                        小計: ¥{{ number_format($item->variant->product->price * $item->quantity) }}
                    </div>
                </li>
            @endforeach
        </ul>

        <p>合計: ¥{{ number_format($total - $discount) }}</p>
        
        <form method="POST" action="{{ route('user.order.complete') }}">
            @csrf
            <button type="submit">購入を確定する</button>
        </form>
        <a href="{{ route('user.order.form') }}">戻る</a>
    </body>
</html>
