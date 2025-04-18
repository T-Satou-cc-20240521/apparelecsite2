<html>
    <head>
        <title>商品管理画面一覧</title>
        <link rel="stylesheet" href="{{ asset('css/admin_top.css') }}">
    </head>
    <body>
        <div id="container">
            <div class="btns">
                <a class="btn_user_top" href="{{ route('admin.product.list') }}">商品一覧</a>
            </div>
            <div class="btns">
                <a class="btn_user_top" href="{{ route('admin.product.create') }}">商品登録</a>
            </div>
            <div class="btns">
                <a class="btn_user_top" href="{{ route('admin.tag.list') }}">商品タグ一覧</a>
            </div>
            <div class="btns">
                <a class="btn_user_top" href="{{ route('admin.tag.create') }}">商品タグ登録</a>
            </div>
            <div class="btns">
                <a class="btn_user_top" href="{{ route('admin.category.list') }}">カテゴリ一覧</a>
            </div>
            <div class="btns">
                <a class="btn_user_top" href="{{ route('admin.category.create') }}">カテゴリ登録</a>
            </div>
            <div class="btns">
                <a class="btn_user_top" href="{{ route('admin.report.index') }}">レポート管理</a>
            </div>  
            <div class="btns">
                <a class="btn_user_top" href="{{ route('admin.top') }}">管理画面に戻る</a>
            </div>  
        </div>
    </body>
</html>