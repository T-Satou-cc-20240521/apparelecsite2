<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>apparelECsite</title>
    </head>
    <body>
        <h2>ご注文ありがとうございました</h2>
        <p>注文番号: {{ $order->order_number }}</p>
        <p>配送先: {{ $order->shipping_address }}</p>
        <p>支払い方法: {{ $order->payment_method }}</p>
        <p>合計金額: ¥{{ number_format($order->total_price - $order->discount_amount) }}</p>

        @if ($order->payment_method === 'bank_transfer')
            <p>下記の口座にお振込みください：</p>
            <ul>
                <li>銀行名：〇〇銀行</li>
                <li>支店名：△△支店</li>
                <li>口座種別：普通</li>
                <li>口座番号：1234567</li>
                <li>口座名義：カ）ショップメイギ</li>
            </ul>
            <p>※ご注文番号（<strong>{{ $order->order_number }}</strong>）を振込名義にご記入ください。</p>
        @endif
        <a href="{{ route('user.top') }}">トップページに戻る</a>
    </body>
</html>