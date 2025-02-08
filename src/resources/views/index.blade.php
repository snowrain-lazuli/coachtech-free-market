@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
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
<div class="index__header">
    <form class="index__header__form-recommendation" action="/sell" method="post">
        @csrf
        <input class="index__header__link-recommendation" type="submit" value="おすすめ">
    </form>
    <form class="index__header__form-mylist" action="/mylist" method="post">
        @csrf
        <input class="index__header__link-mylist" type="submit" value="マイリスト">
    </form>
</div>

<div class="index__content">
    @foreach ($items as $item)
    <div class="index__form">
        <form action="/item/{item_id}" method="post">
            <input class="index__form__image" type="hidden" value="{{$item['id']}}"> <input type="image"
                src="{{asset('storage/' . $item->images->img_url)}}">
            <input class="index-form__item-name" type="submit" value="{{$item['name']}}">
        </form>
    </div>
    @endforeach
</div>
@endsection