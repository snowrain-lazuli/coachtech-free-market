@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">
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

@section('content')
<div class="mypage__account">
    <!-- <img class="mypage__account-img" src="asset('storage/' . profiles->images->img_url)"> -->
    <img class="mypage__account-img" src="">
    <form>
        <!-- <input class="mypage__account-id" type="hidden" value="profiles['id']"> -->
        <input class="mypage__account-id" type="hidden" value="">
        <input class="mypage__account-btn" type="submit" value="プロフィールを編集">
    </form>
</div>
<div class="mypage-form">
    <h2 class="mypage-form__heading content__heading">プロフィール設定</h2>
    <div class="mypage-form__inner">
        <form class="mypage-form__form" action="/mypage" method="post">
            @csrf
            <div class="mypage-form__group">
                <label class="mypage-form__label mypage-form__label-img" for="image">
                    <span class="mypage-form__span-img"></span>
                    <span class="mypage-form__span-btn">画像を選択する</span>
                    <input class="mypage-form__input mypage-form__input-img" type="file" name="image" id="image"
                        accept="image/*">
                </label>
                <p class="mypage-form__error-message">
                    @error('image')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="mypage-form__group">
                <label class="mypage-form__label" for="name">ユーザー名</label>
                <input class="mypage-form__input" type="text" name="name" id="name">
                <p class="mypage-form__error-message">
                    @error('name')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="mypage-form__group">
                <label class="mypage-form__label" for="zip_code">郵便番号</label>
                <input class="mypage-form__input" type="text" name="zip_code" id="zip_code">
                <p>
                    @error('zip_code')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="mypage-form__group">
                <label class="mypage-form__label" for="address">住所</label>
                <input class="mypage-form__input" type="text" name="address" id="address">
                <p>
                    @error('address')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="mypage-form__group">
                <label class="mypage-form__label" for="building">建物名</label>
                <input class="mypage-form__input" type="text" name="building" id="building">
                <p>
                    @error('building')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <input class="mypage-form__btn btn" type="submit" value="更新する">
        </form>

    </div>
</div>
@endsection('content')