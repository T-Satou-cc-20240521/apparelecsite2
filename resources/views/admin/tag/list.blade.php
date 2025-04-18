<head>
<link rel="stylesheet" href="{{ asset('css/admin_product.css') }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タグ一覧</title>
</head>
<body>
    <table class="product_table">
        <tr>
            <th>タグid</th>
            <th>タグ名</th>
            <th>削除</th> 
        </tr> 
        @foreach($tags as $tags)
            <tr>
                <td>{{ $tags->id }}</td>
                <td>{{ Str::limit($tags->name,39,'…') }}</td>
                <td>
                    <a href="#"onclick="event.preventDefault(); if(confirm('本当に削除しますか？')) { document.getElementById('delete_form_{{ $tags->id }}').submit();}">削除</a>
                    <form id="delete_form_{{ $tags->id }}" action="{{ route('admin.tag.delete', ['id' => $tags->id]) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr> 
        @endforeach
    </table>
    <a href="{{ route('admin.product.index')}}">戻る</a>
</body>