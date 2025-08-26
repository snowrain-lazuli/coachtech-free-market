<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <div class="app">
        <header class="header">
            <h1 class="header__heading"><img src="{{ asset('img/logo.svg') }}" alt=""></h1>

            {{-- 検索フォーム --}}
            <form class="search__form" action="/search" method="post">
                @csrf
                <input class="header__middle" type="text" name="search" placeholder="なにをお探しですか？">
            </form>

            {{-- ヘッダーリンク --}}
            <div class="header__link">
                @if (Auth::check())
                <form action="/logout" method="post">
                    @csrf
                    <input class="header__link-logout" type="submit" value="ログアウト">
                </form>
                @else
                <a class="header__link-login" href="/login">ログイン</a>
                @endif

                <form action="/mypage" method="get">
                    @csrf
                    <input class="header__link-mypage" type="submit" value="マイページ">
                </form>

                <form action="/sell" method="get">
                    @csrf
                    <input class="header__link-sell" type="submit" value="出品">
                </form>
            </div>
        </header>

        <div class="content">
            @yield('content')
        </div>
    </div>
    @yield('scripts')
</body>

</html>