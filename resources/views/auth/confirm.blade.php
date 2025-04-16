<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>登録情報確認</title>
    </head>
    <body>
        <form method="post" action="{{ route('auth.register.complete') }}">
            @csrf
            <div class="container">
                <p class="confirm_text">以下の内容で登録します。お間違いないですか？</p>
                <label class="input_label">名前</label>
                <input id="name" class="input_text_full" type="text" name="name" value="{{ old('name', $validated['name']) }}" readonly>
                <label class="input_label">メールアドレス</label>
                <br>
                <input id="email"class="input_text_full" type="email" name="email" value="{{ old('email', $validated['email']) }}" readonly>
                <br>
                <label class="input_label">電話番号</label>
                <br>
                <input id="phone_number"class="input_text_full" type="tel" name="phone_number" value="{{ old('phone_number', $validated['phone_number']) }}" readonly>
                <br>
                <label class="input_label">住所</label>
                <br>
                <input id="address"class="input_text_full" type="address" name="address" value="{{ old('address', $validated['address']) }}" readonly>
                <br>
                <div style="display: none;">
                    <label class="input_label" for="password">パスワード</label><br>
                    <input id="password"class="input_text" type="password" name="password" value="{{ old('password', $validated['password']) }}" readonly>
                </div>
                <input type="submit" name="submit" value="登録" class="submit_button">
                <br>
                <input type='button' onclick='history.back()' value='戻る' class="back_button">
            </div>
        </form>
    </body>
</html>