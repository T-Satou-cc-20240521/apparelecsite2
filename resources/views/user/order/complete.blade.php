<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>apparelECsite</title>
    </head>
    <body>
        <h2>ご注文ありがとうございました</h2>
        <p>注文番号: {{ $order->id }}</p>
        <p>配送先: {{ $order->shipping_address }}</p>
        <p>支払い方法: {{ $order->payment_method }}</p>
        <p>合計金額: ¥{{ number_format($order->total_price - $order->discount_amount) }}</p>
        <a href="{{ route('user.top') }}">トップページに戻る</a>
    </body>
</html>