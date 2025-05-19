<html>
    <head>
        <title>マイページ</title>
        <link rel="stylesheet" href="{{ asset('css/admin_top.css') }}">
    </head>
    <body>
        <div id="container">
            <h2 style="text-align: center; margin-bottom: 30px;">マイページ</h2>

            <div class="btns">
                <a class="btn_user_top" href="{{ route('user.mypage.edit') }}">マイプロフィール</a>
            </div>
            <div class="btns">
                <a class="btn_user_top" href="{{ route('user.order.list') }}">購入履歴</a>
            </div>
            <div class="btns">
                <a class="btn_user_top" href="{{ route('user.favorite.list') }}">お気に入りの商品</a>
            </div>
            <div class="btns">
                <a class="btn_user_top" href="{{ route('user.auth.redirect', ['provider' => 'google']) }}">アカウント連携</a>
            </div>  
            <div class="btns">
                <a class="btn_user_top" href="{{ route('user.top') }}">戻る</a>
            </div>  
        </div>
    </body>
</html>