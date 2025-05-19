<html>
    <head>

    </head>
    <body>
        <div class="container">
            <h2>プロフィール編集</h2>

            @if (session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif

            <form method="POST" action="{{ route('user.mypage.update') }}">
                @csrf

                <label>名前</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')<p style="color:red">{{ $message }}</p>@enderror

                <label>メールアドレス</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<p style="color:red">{{ $message }}</p>@enderror

                <label>電話番号</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                @error('phone_number')<p style="color:red">{{ $message }}</p>@enderror

                <label>住所</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}">
                @error('address')<p style="color:red">{{ $message }}</p>@enderror

                <label>パスワード（変更する場合）</label>
                <input type="password" name="password">
                @error('password')<p style="color:red">{{ $message }}</p>@enderror

                <label>パスワード確認</label>
                <input type="password" name="password_confirmation">

                <button type="submit">更新</button>
            </form>
        </div>
        <div class="btns">
            <a class="btn_user_top" href="{{ route('user.mypage.list') }}">戻る</a>
        </div>
    </body>
</html>



