@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
<div class="profile-form">
    <h2 class="profile-form__heading content__heading">プロフィール設定</h2>
    <div class="profile-form__inner">
        <form class="profile-form__form" action="/mypage/profile" method="post" enctype="multipart/form-data">
            @csrf

            <!-- 画像のアップロード -->
            <div class="profile-form__group">
                <label class="profile-form__label profile-form__label-img" for="image">
                    @if(isset($profiles->image) && $profiles->image)
                    <img class="profile-form__span-img" src="{{ asset($profiles->image->img_url) }}">
                    @else
                    <img class="profile-form__span-img" src="{{ asset('images/default-profile.jpg') }}">
                    @endif
                    <span class="profile-form__span-btn">画像を選択する</span>
                    <input class="profile-form__input profile-form__input-img" type="file" name="image" id="image"
                        accept="image/*">
                </label>
                <p class="profile-form__error-message">
                    @error('image') {{ $message }} @enderror
                </p>
            </div>

            <!-- ユーザー名 -->
            <div class="profile-form__group">
                <label class="profile-form__label" for="name">ユーザー名</label>
                <input class="profile-form__input" type="text" name="name" id="name" value="{{ $profiles->name }}">
                <p class="profile-form__error-message">
                    @error('name') {{ $message }} @enderror
                </p>
            </div>

            <!-- 郵便番号 -->
            <div class="profile-form__group">
                <label class="profile-form__label" for="post_code">郵便番号</label>
                <input class="profile-form__input" type="text" name="post_code" id="post_code"
                    value="{{ $profiles->profile->post_code ?? '' }}">
                <p class="profile-form__error-message">
                    @error('post_code') {{ $message }} @enderror
                </p>
            </div>

            <!-- 住所 -->
            <div class="profile-form__group">
                <label class="profile-form__label" for="address">住所</label>
                <input class="profile-form__input" type="text" name="address" id="address"
                    value="{{ $profiles->profile->address ?? '' }}">
                <p class="profile-form__error-message">
                    @error('address') {{ $message }} @enderror
                </p>
            </div>

            <!-- 建物名 -->
            <div class="profile-form__group">
                <label class="profile-form__label" for="building">建物名</label>
                <input class="profile-form__input" type="text" name="building" id="building"
                    value="{{ $profiles->profile->building ?? '' }}">
                <p class="profile-form__error-message">
                    @error('building') {{ $message }} @enderror
                </p>
            </div>

            <!-- 更新ボタン -->
            <input class="profile-form__btn btn" type="submit" value="更新する">
        </form>
    </div>
</div>
@endsection