<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>apparelECsite</title>
    </head>
    <body>
        <div class="container">
            <h2>注文詳細（注文番号: {{ $order->id }}）</h2>

            <div class="mb-4">
                <h4>顧客情報</h4>
                <p>名前: {{ $order->user->name }}</p>
                <p>メール: {{ $order->user->email }}</p>
            </div>

            <div class="mb-4">
                <h4>配送先情報</h4>
                <p>{{ $order->shipping_address }}</p>
            </div>

            <div class="mb-4">
                <h4>支払い情報</h4>
                <p>支払い方法: 
                    @switch($order->payment_method)
                        @case('credit')
                            クレジットカード
                            @break
                        @case('bank_transfer')
                            銀行振込
                            @break
                        @case('e_money')
                            電子マネー
                            @break
                        @default
                            その他
                    @endswitch
                </p>
                <p>合計金額: ¥{{ number_format($order->total_price) }}</p>
            </div>

            <div class="mb-4">
                <h4>注文状況</h4>
                <p>{{ $order->status->label() }}</p>
            </div>

            <div>
                <h4>注文商品一覧</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>商品名</th>
                            <th>色</th>
                            <th>サイズ</th>
                            <th>数量</th>
                            <th>価格</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ optional($item->variant->product_color)->name ?? 'なし' }}</td>
                                <td>{{ optional($item->variant->product_size)->name ?? 'なし' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>¥{{ number_format($item->price * $item->quantity) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.order.index') }}" class="btn btn-secondary">一覧画面に戻る</a>
            </div>
        </div>
    </body>
</html>