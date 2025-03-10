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
@endsection

@section( 'content')
<div class="item__content">
    <div class="item__img">
        <img class="item__img-img" src="{{ asset($contact->image->img_url) }}" alt="">
    </div>
    <div class="item__detail">
        <div class="item__title">
            <h1>{{ $contact['name'] }}</h1>
            <p>{{ $contact['brand'] }}</p>
        </div>
        <div class="item__price">
            <p>\<span class="item__price-integer">{{ $contact['price'] }}</span>(税込)</p>
        </div>
        <div class="item__status">
            <div class="item__cart">
                <form class="item-cart__form" action="/item/{{$contact->id}}/favorite" method="POST">
                    @csrf
                    @if($contact->user_id === Auth::id())
                    <!-- 出品者の場合 -->
                    <p>出品者です</p>
                    @else
                    @if (!$isPurchased)

                    @if($contact->isFavoritedByUser(Auth::id()))
                    <!-- お気に入り済みの場合 -->
                    <input class="item__status-mark" type="submit" value="★">
                    @else
                    <!-- お気に入りではない場合 -->
                    <input class="item__status-mark" type="submit" value="☆">
                    @endif
                    @else
                    <p class="item__status-mark">-</p>
                    @endif
                    @endif
                </form>
                <p class="item__status-count">{{ $count_data['favorite'] }}</p>
            </div>
            <div class="item__comment-count">
                <p class="item__status-mark">💬</p>
                <p class="item__status-count">{{ $count_data['comment'] }}</p>
            </div>
        </div>
        <div class="item-form">
            @if ($isPurchased)
            <p>購入済みです</p>
            @else
            <form class="item-form__form" action="/purchase/{{$contact->id}}" method="get">
                @csrf
                <input class="item-form__btn btn" type="submit" value="購入手続きへ">
            </form>
            @endif
        </div>
        <div class="item__explanation">
            <h2>商品説明</h2>
            <p>{{ $contact['details'] }}</p>
        </div>
        <div class="item__information">
            <h2>商品の情報</h2>
            <div class="item__category">
                <h3 class="item__category-item">カテゴリー</h3>
                @foreach ($contact->categories as $category)
                <p class="item__category-item">{{ $category->content }}</p>
                @endforeach
            </div>
            <div class="item__status-level">
                <h3 class="item__status-level-item">商品の状態</h3>
                <p class="item__status-level-item">{{ $contact['condition'] }}</p>
            </div>
        </div>
        <div class="item__comment">
            <h2 class="item__comment-title">コメント({{ $count_data['comment'] }})</h2>
            <div class="item__comment__my-account">
                <img class="item__comment-img" src="{{ asset($profiles->image->img_url) }}">
                <p>{{ $profiles->name }}</p>
            </div>
            <div class="item__comment-chat">
                @foreach ($comments as $comment)
                <p>{{ $comment->name_content }}</p>
                @endforeach
            </div>
            <form class="item-form__form" action="/item/{{$contact->id}}" method="post">
                @csrf
                <h2>商品へのコメント</h2>
                <textarea class="item-form__textarea" name="content"></textarea>
                @error('content')
                {{ $message }}
                @enderror
                <input class="mypage-form__btn btn" type="submit" value="コメントを送信する">
                <input class="index__form__image-id" type="hidden" value="{{$contact->id}}">
            </form>
        </div>
    </div>

</div>
</div>
@endsection('content')