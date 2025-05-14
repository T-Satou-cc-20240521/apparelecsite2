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

        <form id="order-form" method="POST" action="{{ route('user.order.confirm') }}">
            @csrf

            <div>
                <label>
                    <input type="radio" name="address_option" value="saved" checked>
                    登録済み住所を使用：{{ $user->address }}
                </label>
            </div>
            <div>
                <label>
                    <input type="radio" name="address_option" value="new">
                    新しい住所を入力する
                </label>
                <input type="text" name="shipping_address" placeholder="新しい住所">
            </div>

            <div>
                <label>支払い方法</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="credit">クレジットカード</option>
                    <option value="e_money">電子マネー</option>
                    <option value="bank_transfer">銀行振込</option>
                </select>
            </div>

            <div id="credit_card_fields" style="display: none;">
                <label>カード情報</label>
                <div id="card-element" style="border: 1px solid #ccc; padding: 10px;"></div>
                <div id="card-errors" role="alert"></div>
            </div>

            <div id="e_money_button_wrapper" style="display: none; margin: 15px 0;">
                <div id="wallet-button" style="width: 300px;"></div>
            </div>

            <div id="e-money_fields" style="display: none;">
                <div id="payment-request-button"></div>
                <div id="e-money-message" style="color: red;"></div>
            </div>

            <input type="hidden" name="card_token" id="card-token">

            <div>
                <label>クーポンコード（任意）</label>
                <input type="text" name="coupon_code">
            </div>

            <button type="submit" id="submit-button">確認へ進む</button>
        </form>

        <script>
            const payjp = Payjp('{{ env('PAYJP_PUBLIC_KEY') }}');
            const elements = payjp.elements();

            const card = elements.create('card');
            card.mount('#card-element');

            card.on('change', function(event) {
                const cardErrors = document.getElementById('card-errors');
                cardErrors.textContent = event.error ? event.error.message : '';
            });

            const paymentSelect = document.getElementById('payment_method');
            const creditFields = document.getElementById('credit_card_fields');
            const eMoneyWrapper = document.getElementById('e_money_button_wrapper');
            const walletButton = document.getElementById('wallet-button');

            let paymentRequest;

            function toggleFields() {
                const method = paymentSelect.value;
                creditFields.style.display = method === 'credit' ? 'block' : 'none';
                eMoneyWrapper.style.display = method === 'e_money' ? 'block' : 'none';
            }

            paymentSelect.addEventListener('change', toggleFields);
            window.addEventListener('DOMContentLoaded', () => {
                toggleFields();

                // 電子マネー用 PaymentRequest 初期化
                paymentRequest = payjp.paymentRequest({
                    country: 'JP',
                    currency: 'jpy',
                    total: {
                        label: '合計金額',
                        amount: 2000, // ← 必要に応じて動的に変更してください
                    },
                    requestPayerName: true,
                    requestPayerEmail: true
                });

                paymentRequest.canMakePayment().then(function (result) {
                    if (result) {
                        paymentRequest.mount('#wallet-button');
                    } else {
                        eMoneyWrapper.style.display = 'none';
                    }
                });

                paymentRequest.on('token', function (response) {
                    document.getElementById('card-token').value = response.token.id;
                    document.getElementById('order-form').submit();
                });

                paymentRequest.on('cancel', function () {
                    alert('電子マネー支払いがキャンセルされました。');
                });

                paymentRequest.on('error', function (error) {
                    alert('エラーが発生しました: ' + error.message);
                });
            });

            document.getElementById('order-form').addEventListener('submit', async function (e) {
                if (paymentSelect.value === 'credit') {
                    e.preventDefault();

                    try {
                        const result = await payjp.createToken(card);
                        if (result.error) {
                            alert('カード情報が正しくありません: ' + result.error.message);
                            return;
                        }

                        document.getElementById('card-token').value = result.id;
                        this.submit();
                    } catch (error) {
                        alert('カード情報のトークン化に失敗しました。');
                    }
                }

                // e_money は paymentRequest により自動送信されるため submit をブロック
                if (paymentSelect.value === 'e_money') {
                    e.preventDefault(); // submitしない（電子マネーはボタンから送信される）
                }
            });

            const eMoneyFields = document.getElementById('e-money_fields');
            const eMoneyMessage = document.getElementById('e-money-message');

            // Payment Request API（Apple Pay / Google Pay）
            const paymentRequest = payjp.paymentRequest({
                country: 'JP',
                currency: 'jpy',
                total: {
                    label: '合計金額',
                    amount: {{ $totalAmount ?? 1000 }}, // ← Bladeから金額を埋め込む
                },
            });

            const prButton = elements.create('paymentRequestButton', {
                paymentRequest: paymentRequest,
            });

            paymentRequest.canMakePayment().then(function (result) {
                if (result) {
                    prButton.mount('#payment-request-button');
                } else {
                    eMoneyMessage.textContent = 'このデバイスでは電子マネー（Apple Pay / Google Pay）が使用できません。';
                }
            });

            paymentRequest.on('token', function (response) {
                // トークンをhiddenに埋め込んで送信
                document.getElementById('card-token').value = response.token.id;
                document.getElementById('order-form').submit();
            });

        </script>
    </body>
</html>




