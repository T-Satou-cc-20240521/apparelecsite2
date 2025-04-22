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
            @if(Auth::user()->role === 1)
                <div class="header_list">
                    <div class="start_section">
                        <a href="{{ route('user.top') }}">apparelECsite</a>
                    </div>
                    <div class="center_section">
                        <form action="{{ route('user.product.list') }}" method="GET">
                            <select name="category" id="category" class="category_box">
                                <option value="" selected>すべて</option>
                                @if($categories->isEmpty())
                                    <option disabled>カテゴリがありません</option>
                                @else
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <input type="text" name="query" class="search_box" placeholder="検索キーワードを入力" required>
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
                        <form action="{{ route('user.product.list') }}" method="GET">
                            <select name="category" id="category" class="category_box">
                                <option value="" selected>すべて</option>
                                @if($categories->isEmpty())
                                    <option disabled>カテゴリがありません</option>
                                @else
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <input type="text" name="query" class="search_box" placeholder="検索キーワードを入力" required>
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
                    <form action="{{ route('user.product.list') }}" method="GET">
                        <select name="category" id="category" class="category_box">
                            <option value="" selected>すべて</option>
                            @if($categories->isEmpty())
                                <option disabled>カテゴリがありません</option>
                            @else
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <input type="text" name="query" class="search_box" placeholder="検索キーワードを入力" required>
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
        <h1>商品一覧</h1>
        @if ($products->isEmpty())
            <p>該当する商品は見つかりませんでした。</p>
        @else
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @if ($product->productImages->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->productImages->first()->path) }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" class="card-img-top" alt="No image">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">価格：¥{{ number_format($product->price) }}</p>
                                <a href="{{ route('user.product.detail', $product->id) }}" class="btn btn-outline-primary">詳細を見る</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </body>
</html>