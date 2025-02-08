@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css')}}">
@endsection

@section('link')
<form class="search__form" action="/search" method="post">
    @csrf
    <input class="header__middle" type="text" name="search" placeholder="なにをお探しですか？">
</form>
<div class="header__link">
    @if (Auth::check())
    <form action="/logout" method="post">
        @csrf
        <input class="header__link-logout" type="submit" value="ログアウト">
    </form>
    @else
    <form action="/login" method="post">
        @csrf
        <input class="header__link-login" type="submit" value="ログイン">
    </form>
    @endif
    <form action="/mypage" method="post">
        @csrf
        <input class="header__link-mypage" type="submit" value="マイページ">
    </form>
    <form action="/sell" method="post">
        @csrf
        <input class="header__link-sell" type="submit" value="出品">
    </form>
</div>
@endsection

@section( 'content')
<div class="item__content">
    <div class="item__img">
        <img class="item__img-img" src="" alt="">
    </div>
    <div class="item__detail">
        <div class="item__title">
            <h1>商品名がここに入る</h1>
            <p>ブランド名</p>
        </div>
        <div class="item__price">
            <p>\<span class="item__price-integer">47,000</span>(税込)</p>
        </div>
        <div class="item__status">
            <div class="item__cart">
                <form class="item-cart__form">
                    @csrf
                    <input class="item__status-mark" type="submit" value="★">
                </form>
                <p class="item__status-count">2</p>
            </div>
            <div class="item__comment-count">
                <p class="item__status-mark">💬</p>
                <p class="item__status-count">1</p>
            </div>
        </div>
        <div class="item-form">
            <form class="item-form__form">
                @csrf
                <input class="item-form__btn btn" type="submit" value="購入手続きへ">
            </form>
        </div>
        <div class="item__explanation">
            <h2>商品説明</h2>
            <p>カラー：グレー<br><br>新品<br>商品の状態は良好です。何もありません。<br>
                <br>購入後、即発送いたします。
            </p>
        </div>
        <div class="item__information">
            <h2>商品の情報</h2>
            <div class="item__category">
                <h3 class="item__category-item">カテゴリー</h3>
                <p class="item__category-item">洋服</p>
                <p class="item__category-item">メンズ</p>
            </div>
            <div class="item__status-level">
                <h3 class="item__status-level-item">商品の状態</h3>
                <p class="item__status-level-item">良好</p>
            </div>
        </div>
        <div class="item__comment">
            <h2 class="item__comment-title">コメント(1)</h2>
            <div class="item__comment__my-account">
                <img class="item__comment-img">
                <p>admin</p>
            </div>
            <div class="item__comment-chat">
                <p>こちらにコメントが入ります
            </div>
            </p>
            <form class="item-form__form">
                <h2>商品へのコメント</h2>
                <textarea class="item-form__textarea"></textarea>
                <input class="mypage-form__btn btn" type="submit" value="コメントを送信する">
            </form>
        </div>
    </div>

</div>
</div>
@endsection('content')