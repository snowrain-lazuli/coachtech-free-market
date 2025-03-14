@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
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
<div class="address-form">
    <h2 class="address-form__heading content__heading">住所の変更</h2>

    <div class="address-form__inner">
        <form class="address-form__form" action="/purchase/{{ $item_id }}" method="post">
            @csrf

            <div class="address-form__group">
                <label class="address-form__label" for="post_code">郵便番号</label>
                <input class="address-form__input" type="text" name="post_code" id="post_code"
                    value="{{ $profiles->post_code }}">
                <p class="address-form__error-message">
                    @error('post_code')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="address-form__group">
                <label class="address-form__label" for="address">住所</label>
                <input class="address-form__input" type="text" name="address" id="address"
                    value="{{ $profiles->address }}">
                <p class="address-form__error-message">
                    @error('address')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="address-form__group">
                <label class="address-form__label" for="building">建物名</label>
                <input class="address-form__input" type="text" name="building" id="building"
                    value="{{ $profiles->building }}">
                <p class="address-form__error-message">
                    @error('building')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <input class="address-form__btn btn" type="submit" value="更新する">
        </form>
    </div>
</div>
@endsection