<html>
    <head>
        <script src="https://js.pay.jp/v2/pay.js"></script>
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

            <div id="credit_card_fields" style="display: none;">
                <label>カード番号</label>
                <input type="text" id="card-number" placeholder="1234 5678 9012 3456">

                <label>有効期限（月）</label>
                <input type="text" id="exp-month" placeholder="MM">

                <label>有効期限（年）</label>
                <input type="text" id="exp-year" placeholder="YYYY">

                <label>CVC</label>
                <input type="text" id="cvc" placeholder="CVC">
            </div>

            <input type="hidden" name="card_token" id="card-token">

            <div>
                <label>クーポンコード（任意）</label>
                <input type="text" name="coupon_code">
            </div>
            <button type="submit">確認へ進む</button>
        </form>
        <script>
            const payjp = Payjp('{{ env('PAYJP_PUBLIC_KEY') }}');
            const elements = payjp.elements();
            
            document.getElementById('payment_method').addEventListener('change', function () {
                const creditFields = document.getElementById('credit_card_fields');
                creditFields.style.display = this.value === 'credit' ? 'block' : 'none';
            });

            document.getElementById('order-form').addEventListener('submit', async function (e) {
                const paymentMethod = document.getElementById('payment_method').value;
                if (paymentMethod !== 'credit') return;

                e.preventDefault();

                try {
                    const result = await payjp.createToken('card', {
                        number: document.getElementById('card-number').value,
                        cvc: document.getElementById('cvc').value,
                        exp_month: document.getElementById('exp-month').value,
                        exp_year: document.getElementById('exp-year').value
                    });

                    if (result.error) {
                        alert('カード情報が正しくありません: ' + result.error.message);
                        return;
                    }

                    document.getElementById('card-token').value = result.id;
                    this.submit();

                } catch (error) {
                    alert('トークン作成中にエラーが発生しました。');
                    console.error(error);
                }
            });
        </script>
    </body>
</html>

