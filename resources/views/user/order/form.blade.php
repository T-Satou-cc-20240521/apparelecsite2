<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>apparelECsite</title>
    </head>
    <body>
        <h2>ご購入手続き</h2>
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('user.order.confirm') }}">
            @csrf
            <div>
                <label><input type="radio" name="address_option" value="saved" checked> 登録済み住所を使用：{{ $user->address }}</label>
            </div>
            <div>
                <label><input type="radio" name="address_option" value="new"> 新しい住所を入力する</label>
                <input type="text" name="shipping_address" placeholder="新しい住所">
            </div>
            <div>
                <label>支払い方法</label>
                <select name="payment_method" required>
                    <option value="credit">クレジットカード</option>
                    <option value="e_money">電子マネー</option>
                    <option value="bank_transfer">銀行振込</option>
                </select>
            </div>
            <div>
                <label>クーポンコード（任意）</label>
                <input type="text" name="coupon_code">
            </div>
            <button type="submit">確認へ進む</button>
        </form>
    </body>
</html>

