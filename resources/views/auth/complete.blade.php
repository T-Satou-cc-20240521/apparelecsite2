<html>
    <head>
    <link rel="stylesheet" href="{{ asset('css/complete.css') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>登録完了</title>
    </head>
    <body>
        <div class="container">
            <p class="text">ユーザー登録が完了しました。</p>
            <div class="top_button">
                <a href="{{ route('user.top') }}" class="top_url">トップへ戻る</a>
            </div>
            <div class="login_button">
                <a href= "{{ route('auth.login') }}" class="login_url">ログイン</a>
            </div>
        </div>
    </body>
</html> 