<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>apparelECsite - 注文確認</title>
</head>
<body>
    @if (session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    <h2>注文内容確認</h2>

    <p><strong>配送先住所:</strong> {{ $shippingAddress }}</p>

    <p><strong>支払い方法:</strong> {{ $paymentMethodLabel }}</p>

    @if ($coupon)
        <p><strong>クーポン適用:</strong> {{ $coupon->code }} (¥{{ number_format($discount) }} 割引)</p>
    @endif

    <ul>
        @foreach ($cartItems as $item)
            <li style="margin-bottom: 20px;">
                <img src="{{ asset('storage/' . $item->variant->product_images->first()->image_path) }}" alt="商品画像" width="100">
                <div>
                    <strong>{{ $item->variant->product->name }}</strong><br>
                    色: {{ $item->variant->product_color->name }}<br>
                    サイズ: {{ $item->variant->product_size->name }}<br>
                    数量: {{ $item->quantity }}<br>
                    小計: ¥{{ number_format($item->variant->product->price * $item->quantity) }}
                </div>
            </li>
        @endforeach
    </ul>

    <p><strong>合計金額:</strong> ¥{{ number_format($total - $discount) }}</p>

    <form method="POST" action="{{ route('user.order.complete') }}">
        @csrf
        {{-- Hidden inputs to pass values to the complete handler --}}
        <input type="hidden" name="shipping_address" value="{{ $shippingAddress }}">
        <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">
        <input type="hidden" name="card_token" value="{{ $cardToken ?? '' }}">
        <input type="hidden" name="emoney_token" value="{{ $emoneyToken ?? '' }}">
        <input type="hidden" name="coupon_code" value="{{ $coupon->code ?? '' }}">

        <button type="submit">購入を確定する</button>
    </form>

    <p>
        <a href="{{ route('user.order.form') }}">← 戻る</a>
    </p>
</body>
</html>

