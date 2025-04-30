<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>apparelECsite</title>
    </head>
    <body>
        <h2>注文内容の確認</h2>
        <p><strong>配送先住所:</strong> {{ $shipping_address }}</p>
        <p><strong>支払い方法:</strong> {{ $payment_method }}</p>
        @if ($coupon)
            <p><strong>クーポン:</strong> {{ $coupon->code }}（割引: ¥{{ number_format($discount) }}）</p>
        @endif
        <h3>商品一覧</h3>
        <ul>
            @foreach ($carts as $item)
                <li>
                    {{ $item->product->name }} × {{ $item->quantity }}  
                    - ¥{{ number_format($item->variant->price * $item->quantity) }}
                </li>
            @endforeach
        </ul>
        <p><strong>合計:</strong> ¥{{ number_format($total - $discount) }}</p>
        <form action="{{ route('user.order.complete') }}" method="POST">
            @csrf
            <input type="hidden" name="shipping_address" value="{{ $shipping_address }}">
            <input type="hidden" name="payment_method" value="{{ $payment_method }}">
            <input type="hidden" name="coupon_id" value="{{ optional($coupon)->id }}">
            <button type="submit">購入を確定する</button>
        </form>
        <a href="{{ route('user.order.form') }}">戻る</a>
    </body>
</html>
