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
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div id="product-image">
                        <img src="{{ asset('storage/' . $product->variants->first()->product_images->first()->image_path) }}" alt="商品画像" class="img-fluid" id="product-image-display">
                    </div>
                </div>
                <div class="col-md-6">
                    <h1>{{ $product->name }}</h1>
                    <p>{{ number_format($product->price) }} 円</p>
                    <h4>この商品について</h4>
                    <p>{{ $product->description }}</p>
                    <div class="mb-3">
                        <h4>COLOR</h4>
                        @foreach($colors as $index => $colorVariant)
                            <input type="radio" name="color_id" value="{{ $colorVariant->color_id }}" id="color_{{ $colorVariant->color_id }}" {{ $index === 0 ? 'checked' : '' }}>
                            <label for="color_{{ $colorVariant->color_id }}">
                                {{ $colorVariant->product_color->name }}
                            </label>
                        @endforeach
                    </div>
                    <div class="mb-3" id="size-container">
                        <h4>SIZE</h4>
                        
                    </div>
                    <h4 id="stock_quantity" style="display: none;"></h4>
                    <div class="mb-3">
                        <h4>数量</h4>
                        <input type="number" id="quantity" name="quantity" min="1" value="1" step="1" class="form-control" style="width: 100px;">
                    </div>
                    <button class="btn btn-primary" id="add-to-cart" disabled>カートに入れる</button>
                </div>
                <a class="btn_user_top" href="{{ route('user.product.list') }}">商品一覧に戻る</a>
            </div>
        </div>
    <script>
        const variants = @json($product->variants);
    </script>
    <script src="{{ asset('/js/product_detail.js') }}"></script>
    <script src="{{ asset('/js/header.js') }}"></script>
    </body>
</html>