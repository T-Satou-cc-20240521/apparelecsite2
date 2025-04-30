<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>apparelECsite</title>
    </head>
    <body>
        <h2>ご購入手続き</h2>
        <form action="{{ route('user.order.confirm') }}" method="POST">
            @csrf
            <h3>配送先住所の選択</h3>
            @if ($user->address)
                <div>
                    <label>
                        <input type="radio" name="address_option" value="saved" checked>
                        登録済み住所を使用：{{ $user->address }}
                    </label>
                </div>
            @endif
            <div>
                <label>
                    <input type="radio" name="address_option" value="new" {{ !$user->shipping_address ? 'checked' : '' }}>
                    新しい住所を入力する
                </label>
            </div>
            <div id="new_address_input" style="display: none;">
                <label for="shipping_address">新しい配送先住所：</label>
                <input type="text" name="shipping_address" id="shipping_address" value="{{ old('shipping_address') }}">
            </div>
            <div>
                <label for="payment_method">支払い方法</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="credit">クレジットカード</option>
                    <option value="e_money">電子マネー</option>
                    <option value="bank_transfer">銀行振込</option>
                </select>
            </div>
            <div>
                <label for="coupon_code">クーポンコード（任意）</label>
                <input type="text" name="coupon_code" id="coupon_code">
            </div>
            <button type="submit">確認へ進む</button>
        </form>
    </body>
</html>

