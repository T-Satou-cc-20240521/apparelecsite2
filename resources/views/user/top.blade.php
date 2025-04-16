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
        <h1>welcome to apparelECsite</h1>
        <div class="banner-container">
            <div class="banner-slider">
                @foreach ($banners as $banner)
                    <div class="banner-slide">
                        <a href="{{ $banner->link }}">
                            <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->title }}" class="banner-image">
                        </a>
                    </div>
                @endforeach
            </div>
            <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
            <button class="next" onclick="moveSlide(1)">&#10095;</button>
        </div>
    </body>
</html>