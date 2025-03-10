@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
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

@section('content')
<div class="index__header">
    <form class="index__header__form-recommendation" action="/" method="get">
        @csrf
        <input class="index__header__link-recommendation" type="submit" value="おすすめ">
    </form>

    <form class="index__header__form-mylist" action="/" method="post">
        @csrf
        <input type="hidden" name="page" value="mylist">
        <input class="index__header__link-mylist" type="submit" value="マイリスト">
    </form>
</div>

<div class="index__content">
    @foreach ($contacts as $contact)
    <div class="index__form">
        <form action="/item/{{$contact->id}}" method="get">
            <input class="index__form__image-id" type="hidden" value="{{$contact->id}}">
            <input class="index__form__image" type="image" src="{{ $contact->image->img_url }}">
            <input class="index-form__item-name" type="submit" value="{{$contact->name}}">
        </form>
    </div>
    @endforeach

    <div class="index__form__paginate">
        {{ $contacts->links() }}
    </div>
</div>
@endsection