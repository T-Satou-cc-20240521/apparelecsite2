<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>apparelECsite - ご注文完了</title>
</head>
<body>
    <h2>ご注文ありがとうございました</h2>

    <p><strong>注文番号:</strong> {{ $order->order_number }}</p>
    <p><strong>配送先:</strong> {{ $order->shipping_address }}</p>

    <p><strong>支払い方法:</strong>
        @switch($order->payment_method)
            @case('credit')
                クレジットカード
                @break
            @case('e_money')
                電子マネー
                @break
            @case('bank_transfer')
                銀行振込
                @break
            @default
                {{ $order->payment_method }}
        @endswitch
    </p>

    <p><strong>合計金額:</strong> ¥{{ number_format($order->total_price - $order->discount_amount) }}</p>

    @if ($order->payment_method === 'bank_transfer')
        <div style="margin-top: 20px;">
            <p><strong>下記の口座にお振込みください：</strong></p>
            <ul>
                <li>銀行名：〇〇銀行</li>
                <li>支店名：△△支店</li>
                <li>口座種別：普通</li>
                <li>口座番号：1234567</li>
                <li>口座名義：カ）ショップメイギ</li>
            </ul>
            <p>※ご注文番号（<strong>{{ $order->order_number }}</strong>）を振込名義にご記入ください。</p>
        </div>
    @endif

    <div style="margin-top: 30px;">
        <a href="{{ route('user.top') }}">トップページに戻る</a>
    </div>
</body>
</html>
