@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
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

@section('content')
<div class="mypage__account">
    <img class="mypage__account-img" src="{{ asset($profiles->img_url) }}">
    <form action="/mypage/profile" method="get">
        @csrf
        <input class="mypage__account-btn" type="submit" value="プロフィールを編集">
    </form>

    <form class="mypage__account-recommendation" action="/mypage" method="post">
        @csrf
        <input type="hidden" name="page" value="sell">
        <input class="mypage__account__link-recommendation" type="submit" value="出品した商品">
    </form>

    <form class="mypage__account-mypage" action="/mypage" method="post">
        @csrf
        <input type="hidden" name="page" value="buy">
        <input class="mypage__account__link-mypage" type="submit" value="購入した商品">
    </form>
</div>

<div class="mypage__content">
    @if (!empty($contacts))
    @foreach ($contacts as $contact)
    <div class="mypage__form">
        <form action="/item/{{$contact->id}}" method="get">
            <input class="mypage__form__image-id" type="hidden" value="{{$contact->id}}">
            <input class="mypage__form__image" type="image" src="{{ $contact->image->img_url }}">
            <input class="mypage-form__item-name" type="submit" value="{{$contact->name}}">
        </form>
    </div>
    @endforeach
    @endif
</div>
@endsection