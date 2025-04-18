<head>
<link rel="stylesheet" href="{{ asset('css/admin_product.css') }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カテゴリー一覧</title>
</head>
<body>
    <table class="product_table">
        <tr>
            <th>カテゴリid</th>
            <th>カテゴリ名</th>
            <th>削除</th> 
        </tr> 
        @foreach($categories as $categories)
            <tr>
                <td>{{ $categories->id }}</td>
                <td>{{ Str::limit($categories->name,39,'…') }}</td>
                <td>
                    <a href="#"onclick="event.preventDefault(); if(confirm('本当に削除しますか？')) { document.getElementById('delete_form_{{ $categories->id }}').submit();}">削除</a>
                    <form id="delete_form_{{ $categories->id }}" action="{{ route('admin.category.delete', ['id' => $categories->id]) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr> 
        @endforeach
    </table>
    <a href="{{ route('admin.product.index')}}">戻る</a>
</body>