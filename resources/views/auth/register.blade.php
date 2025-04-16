<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/register.css') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>新規会員登録</title>
    </head>
    <body>
        <div class="container">
            <p class="title">会員登録</p>
            <form method="post" action="{{ route('auth.register.confirm') }}" >
                @csrf
                <label class="input_label">名前</label>
                <input class="input_text_full" type="text" name="name" value="{{ old('name') }}" required maxlength="30">
                <br>
                @error('name')
                    <li class="error_message">{{ $message }}</li>
                @enderror
                <label class="input_label">メールアドレス</label>
                <input class="input_text_full" type="email" name="email" value="{{ old('email') }}" required>
                <br>
                @error('email')
                    <li class="error_message">{{ $message }}</li>
                @enderror
                <label class="input_label">電話番号（任意）</label>
                <input class="input_text_full" type="tel" name="phone_number" value="{{ old('phone_number') }}">
                <br>
                @error('phone_number')
                    <li class="error_message">{{ $message }}</li>
                @enderror
                <label class="input_label">住所（任意）</label>
                <input class="input_text_full" type="text" name="address" value="{{ old('address') }}">
                <br>
                @error('address')
                    <li class="error_message">{{ $message }}</li>
                @enderror
                <label class="input_label">パスワード</label>
                <input class="input_text_full" type="password" name="password" required minlength="7" maxlength="50" autocomplete="new-password">
                <br>
                @error('password')
                    <li class="error_message">{{ $message }}</li>
                @enderror
                <button type="submit" class="submit_button">送信</button>
            </form>
        </div>
        <script src="{{ asset('/js/register.js') }}"></script>
    </body>
</html>