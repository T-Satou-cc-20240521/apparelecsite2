<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/top.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>apparelECsite</title>
    </head>
    <body>
    <header class="top_area">
        @auth
            @if(Auth::user()->is_admin === true)
                <div class="header_list">
                    <div class="start_section">
                        <a href="{{ route('user.top') }}">apparelECsite</a>
                    </div>
                    <div class="center_section">
                        <form id="searchForm" action="{{ route('user.product.list') }}" method="GET">
                            <select name="category" id="category" class="category_box">
                                <option value="" {{ request('category') == '' ? 'selected' : '' }}>すべて</option>
                                @if($categories->isEmpty())
                                    <option disabled>カテゴリがありません</option>
                                @else
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <input type="text" id="queryInput" name="query" class="search_box"
                                placeholder="検索キーワードを入力"
                                value="{{ request('query') }}">
                            <button type="submit" class="query_button">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="end_section">
                        <ul class="header_ul">
                            <li class="header_link"><a class="link_text" href="{{ route('user.cart.list') }}">カート</a></li>
                            <li class="header_link"><a class="link_text" href="{{ route('admin.top') }}">管理画面</a></li>
                            <li class="header_link">
                                <a class="link_text_logout" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <div class="header_list">
                    <div class="start_section">
                        <a href="{{ route('user.top') }}">apparelECsite</a>
                    </div>
                    <div class="center_section">
                        <form id="searchForm" action="{{ route('user.product.list') }}" method="GET">
                            <select name="category" id="category" class="category_box">
                                <option value="" {{ request('category') == '' ? 'selected' : '' }}>すべて</option>
                                @if($categories->isEmpty())
                                    <option disabled>カテゴリがありません</option>
                                @else
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <input type="text" id="queryInput" name="query" class="search_box"
                                placeholder="検索キーワードを入力"
                                value="{{ request('query') }}">
                            <button type="submit" class="query_button">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="end_section">
                        <ul class="header_ul">
                            <li class="header_link"><a class="link_text" href="{{ route('user.cart.list') }}">カート</a></li>
                            <li class="header_link"><a class="link_text" href="{{ route('user.mypage.list') }}">マイページ</a></li>
                            <li class="header_link">
                                <a class="link_text_logout" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
        @endauth
        @guest
            <div class="header_list">
                <div class="start_section">
                    <a href="{{ route('user.top') }}">apparelECsite</a>
                </div>
                <div class="center_section">
                    <form id="searchForm" action="{{ route('user.product.list') }}" method="GET">
                        <select name="category" id="category" class="category_box">
                            <option value="" {{ request('category') == '' ? 'selected' : '' }}>すべて</option>
                            @if($categories->isEmpty())
                                <option disabled>カテゴリがありません</option>
                            @else
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <input type="text" id="queryInput" name="query" class="search_box"
                            placeholder="検索キーワードを入力"
                            value="{{ request('query') }}">
                        <button type="submit" class="query_button">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="end_section">
                    <ul class="header_ul">
                    <li class="header_link"><a class="link_text" href="{{ route('user.cart.list') }}">カート</a></li>
                        <li class="header_link"><a class="link_text" href="{{ route('auth.login') }}">ログイン</a></li>
                        <li class="header_link"><a class="link_text" href="{{ route('auth.register') }}">会員登録</a></li>
                    </ul>
                </div>
            </div>
        @endguest
    </header>
    @php
        $filteredProducts = $products->filter(function($product) {
            return $product->variants->where('is_active', 1)->where('stock_quantity', '>', 0)->isNotEmpty();
        });
    @endphp
    <h1>商品一覧</h1>
    @if ($filteredProducts->isEmpty())
        <p>該当する商品は見つかりませんでした。</p>
        <a class="btn_user_top" href="{{ route('user.top') }}">TOPに戻る</a>
    @else
        <div class="row">
            @foreach ($filteredProducts as $product)
                @php
                    $variant = $product->variants->where('stock_quantity', '>', 0)->first();
                @endphp
                <div class="product-card">
                    <img src="{{ asset('storage/' . $variant->product_images->first()->image_path) }}" alt="商品画像" class="img-thumbnail">
                    <h3>{{ $product->name }}</h3>
                    <p class="card-text">価格：¥{{ number_format($product->price) }}</p>
                    <a href="{{ route('user.product.detail', $product->id) }}" class="btn btn-outline-primary">詳細を見る</a>
                    <a class="btn_user_top" href="{{ route('user.top') }}">TOPに戻る</a>
                </div>
            @endforeach
        </div>
    @endif
    <script src="{{ asset('/js/header.js') }}"></script>
    </body>
</html>