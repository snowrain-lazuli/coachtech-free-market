@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css')}}">
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
    <form action="/profile" method="post">
        @csrf
        <input class="header__link-profile" type="submit" value="マイページ">
    </form>
    <form action="/sell" method="post">
        @csrf
        <input class="header__link-sell" type="submit" value="出品">
    </form>
</div>
@endsection

@section('content')
<div class="profile-form">
    <h2 class="profile-form__heading content__heading">プロフィール設定</h2>
    <div class="profile-form__inner">
        <form class="profile-form__form" action="/profile" method="post">
            @csrf
            <div class="profile-form__group">
                <label class="profile-form__label profile-form__label-img" for="image">
                    <span class="profile-form__span-img"></span>
                    <span class="profile-form__span-btn">画像を選択する</span>
                    <input class="profile-form__input profile-form__input-img" type="file" name="image" id="image"
                        accept="image/*">
                </label>
                <p class="profile-form__error-message">
                    @error('image')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="profile-form__group">
                <label class="profile-form__label" for="name">ユーザー名</label>
                <input class="profile-form__input" type="text" name="name" id="name">
                <p class="profile-form__error-message">
                    @error('name')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="profile-form__group">
                <label class="profile-form__label" for="zip_code">郵便番号</label>
                <input class="profile-form__input" type="text" name="zip_code" id="zip_code">
                <p>
                    @error('zip_code')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="profile-form__group">
                <label class="profile-form__label" for="address">住所</label>
                <input class="profile-form__input" type="text" name="address" id="address">
                <p>
                    @error('address')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="profile-form__group">
                <label class="profile-form__label" for="building">建物名</label>
                <input class="profile-form__input" type="text" name="building" id="building">
                <p>
                    @error('building')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <input class="profile-form__btn btn" type="submit" value="更新する">
        </form>

    </div>
</div>
@endsection('content')