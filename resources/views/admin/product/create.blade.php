<html>
    <head>
        <title>商品追加</title>
        <link rel="stylesheet" href="{{ asset('/css/admin_product.css') }}">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    </head>
    <body>
        <div id="container">
            <form method="post" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}      
                <label class="input_label" for="category_id">カテゴリー選択</label>
                <br>
                <select id="category_id" class="text_input_w100" name="category_id" required>
                    @if($categories->isEmpty())
                        <option disabled>カテゴリがありません</option>
                    @else
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    @endif
                </select>
                @error('category_id')
                    <li class="error_message">{{ $message }}</li>
                @enderror
                <br>
                <label class="input_label" for="name">商品名</label>
                <br>
                <input id="name" class="text_input_w100" type="text" name="name" required maxlength="255" value="{{ old('name')}}">
                @error('name')
                    <li class="error_message">{{ $message }}</li>
                @enderror
                <br>
                <label class="input_label" for="price">価格</label>
                <br>
                <input id="price" class="text_input_w100" type="number" name="price" required min="0" max="999999999" value="{{ old('price')}}">
                @error('price')
                    <li class="error_message">{{ $message }}</li>
                @enderror
                <br>
                <label class="input_label" for="description">商品説明文</label>
                <br>
                <textarea id="description" class="text_input_w100" type="text" name="description" required maxlength="255" value="{{ old('description')}}"></textarea>
                @error('description')
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
