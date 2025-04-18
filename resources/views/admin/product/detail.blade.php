<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/admin_product.css') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>商品詳細</title>
    </head>
    <body>
        <div id="left_container">
            <form method="POST" action="{{ route('admin.product.update', ['id' => $product->id]) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <label class="input_label" for="name">商品名</label>
                <input id="name" class="text_input_w100" type="text" name="name" required maxlength="255" value="{{ old('name', $product->name) }}">
                @error('name')
                    <li class="error_message">{{ $message }}</li>
                @enderror
                <br>
                <label class="input_label" for="price">値段</label>
                <input id="price" class="text_input_w100" type="number" name="price" required min="0" max="999999999" value="{{ old('price', $product->price) }}">
                @error('price')
                    <li class="error_message">{{ $message }}</li>
                @enderror
                <br>
                <label class="input_label" for="category_id">カテゴリ</label>
                <br>
                <span>{{ $product->category->name }}</span>
                <input type="hidden" id="category_id" name="category_id" value="{{ $product->category_id }}" required>
                @error('category_id')
                    <li class="error_message">{{ $message }}</li>
                @enderror
                <br>
                <input class="submit_btn" type="submit" value="更新">
            </form>
            <div class="back_btn">
                <a href="{{ route('admin.product.list')}}">戻る</a>
            </div>  
        </div>
        <div class="right_container">
            <h2>商品バリエーション</h2>
            <form method="POST" action="{{ route('admin.product.variants.update', $product->id) }}">
                @csrf
                <div class="variant-list scrollable">
                    @foreach ($product->variants as $index => $variant)
                        <div class="variant-item border p-3 mb-2 rounded bg-white shadow">
                            <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                            <div><strong>色：</strong>{{ $variant->color }}</div>
                            <div><strong>サイズ：</strong>{{ $variant->size }}</div>
                            <div><strong>在庫：</strong>{{ $variant->stock_quantity }}</div>
                            <div class="mt-2">
                                <label><strong>公開設定：</strong></label><br>
                                <label>
                                    <input type="radio" name="variants[{{ $index }}][is_active]" value="1"
                                        {{ $variant->is_active ? 'checked' : '' }}> 公開
                                </label>
                                <label class="ms-2">
                                    <input type="radio" name="variants[{{ $index }}][is_active]" value="0"
                                        {{ !$variant->is_active ? 'checked' : '' }}> 非公開
                                </label>
                            </div>
                            <div class="mt-2">
                                <button type="submit" formaction="{{ route('admin.product.variant.delete', $variant->id) }}" class="btn btn-danger"
                                    onclick="return confirm('このバリエーションを削除しますか？')">削除</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">公開設定を保存</button>
                </div>
            </form>
            <h3>バリエーションを追加</h3>
            <form method="POST" action="{{ route('admin.product.variant.store', $product->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>色</label>
                    <input type="text" name="color" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>サイズ</label>
                    <input type="text" name="size" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>在庫数</label>
                    <input type="number" name="stock_quantity" class="form-control" min="0" required>
                </div>
                <div class="mb-3">
                    <label>画像</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="mb-3">
                    <label>公開状態</label><br>
                    <label><input type="radio" name="is_active" value="1" checked> 公開</label>
                    <label class="ms-2"><input type="radio" name="is_active" value="0"> 非公開</label>
                </div>
                <button type="submit" class="btn btn-success">バリエーション追加</button>
            </form>
        </div>
    </body>
</html>