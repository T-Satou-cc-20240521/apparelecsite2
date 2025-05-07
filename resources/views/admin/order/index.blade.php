<html>
    <head>

    </head>
    <body>
        <div>
            <h1>注文一覧</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ユーザー</th>
                        <th>合計金額</th>
                        <th>支払い方法</th>
                        <th>注文日</th>
                        <th>詳細</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ number_format($order->total_price) }}円</td>
                        <td>{{ $order->payment_method_label }}</td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td><a href="{{ route('admin.order.show', $order->id) }}">詳細</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <a href="{{ route('admin.top') }}" class="btn btn-secondary mb-3">管理者TOPに戻る</a>
        </div>
    </body>
</html>