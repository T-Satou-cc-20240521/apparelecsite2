<html>
    <head>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ログイン</title>
    </head>
    <body>
        <div class="container">
            <p class="title">ログイン</p>
            <form method="post" action="{{ route('auth.login.submit') }}">
                @csrf
                <label class="input_label">メールアドレス</label>
                <br>
                <input class="input_text" style="margin-bottom: 20px;" type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <p class="error_message">{{ $message }}</p>
                @enderror
                <br>
                <label class="input_label">パスワード</label>
                <br>
                <input class="input_text" type="password" name="password" required>
                <br>
                @error('password')
                    <p class="error_message">{{ $message }}</p>
                    <br>
                @enderror
                <button class="submit_button" type="submit">ログイン</button>
            </form>
            <a class="register_url" href="{{ route('auth.register') }}">会員登録がまだの方はコチラ</a>
        </div>
    </body>
</html>