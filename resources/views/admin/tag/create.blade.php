<html>
    <head>
        <title>商品TAG追加</title>
        <link rel="stylesheet" href="{{ asset('/css/admin_product.css') }}">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    </head>
    <body>
        <div id="container">
            <form method="post" action="{{ route('admin.tag.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}      
                <br>
                <label class="input_label" for="name">商品名</label>
                <br>
                <input id="name" class="text_input_w100" type="text" name="name" required maxlength="255" value="{{ old('name')}}">
                @error('name')
                    <li class="error_message">{{ $message }}</li>
                @enderror
                <br>
                <input class="submit_btn" type="submit" value="登録">
            </form>
            <div class="back_btn">
                <a href="{{ route('admin.product.index')}}">戻る</a>
            </div>  
        </div>
    </body>
</html>