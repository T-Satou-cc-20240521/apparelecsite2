<html>
    <head>

    </head>
    <body>
        <div class="container">
            <h2>購入履歴</h2>

            @if($orders->isEmpty())
                <p>購入履歴がありません。</p>
            @else
                @foreach($orders as $order)
                    <div class="order-box">
                        <p><strong>注文日:</strong> {{ $order->created_at->format('Y年m月d日 H:i') }}</p>
                        <p><strong>合計金額:</strong> ¥{{ number_format($order->total_amount) }}</p>
                        <p><strong>ステータス:</strong> {{ $order->status }}</p>

                        <ul>
                            @foreach($order->orderItems as $item)
                                <li>
                                    {{ $item->product->name ?? '商品名不明' }} / ¥{{ number_format($item->price) }} x {{ $item->quantity }}
                                </li>
                            @endforeach
                        </ul>
                        <hr>
                    </div>
                @endforeach

                {{ $orders->links() }}
            @endif
        </div>
    </body>
</html>