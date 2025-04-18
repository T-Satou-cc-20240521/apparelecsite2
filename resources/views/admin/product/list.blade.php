<head>
<link rel="stylesheet" href="{{ asset('css/admin_product.css') }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧</title>
</head>
<body>
    <table class="product_table">
        <tr>
            <th>登録順</th>
            <th>商品名</th>
            <th>カテゴリ</th>
            <th>価格</th>
            <th>詳細</th>
            <th>削除</th> 
        </tr> 
        @foreach($products as $products)
            <tr>
                <td>{{ $products->display_number }}</td>
                <td>{{ Str::limit($products->name,39,'…') }}</td>
                <td>{{ $products->category->name }}</td>
                <td>{{ $products->price }}</td>
                <td><a href="{{ route('admin.product.detail',['id'=>$products->id]) }}">詳細</a></td>
                <td>
                    <a href="#"onclick="event.preventDefault(); if(confirm('本当に削除しますか？')) { document.getElementById('delete_form_{{ $products->id }}').submit();}">削除</a>
                    <form id="delete_form_{{ $products->id }}" action="{{ route('admin.product.delete', ['id' => $products->id]) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr> 
        @endforeach
    </table>
    <a href="{{ route('admin.product.index')}}">戻る</a>
</body>