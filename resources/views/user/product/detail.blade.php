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
                        @foreach($colors as $colorVariant)
                            <input type="radio" name="color_id" value="{{ $colorVariant->color_id }}" id="color_{{ $colorVariant->color_id }}">
                            <label for="color_{{ $colorVariant->color_id }}">
                                {{ $colorVariant->product_color->name }}
                            </label>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <h4>SIZE</h4>
                        @foreach($sizes as $sizeVariant)
                            <input type="radio" name="variant_id" value="{{ $sizeVariant->size_id }}" id="size_{{ $sizeVariant->size_id }}">
                            <label for="size_{{ $sizeVariant->size_id }}">
                                {{ $sizeVariant->product_size->name }}
                            </label>
                        @endforeach
                    </div>
                    @if($variant->stock_quantity > 0)
                        <h4>在庫あり</h4>
                    @else
                        <h4>SOLD OUT</h4>
                    @endif
                    <button class="btn btn-primary" id="add-to-cart">カートに入れる</button>
                </div>
            </div>
        </div>
    </body>
</html>