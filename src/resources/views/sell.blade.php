@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('link')
<form class="search__form" action="/search" method="post">
    @csrf
    <input class="header__middle" type="text" name="search" placeholder="なにをお探しですか？">
</form>
<div class="header__link">
    <form action="/logout" method="post">
        @csrf
        <input class="header__link-logout" type="submit" value="ログアウト">
    </form>
    <form action="/mypage" method="get">
        <input class="header__link-mypage" type="submit" value="マイページ">
    </form>
    <form action="/sell" method="get">
        <input class="header__link-sell" type="submit" value="出品">
    </form>
</div>
@endsection

@section('content')
<div class="sell-form">
    <h1 class="sell-form__heading content__heading">商品の出品</h1>
    <div class="sell-form__inner">
        <form class="sell-form__form" action="/sell" method="post" enctype="multipart/form-data">
            @csrf
            <div class="sell-form__group">
                <label class="sell-form__label" for="image">商品画像</label>
                <div class="sell-form__image-container">
                    <label class="sell-form__span-btn" for="image">画像を選択する</label>
                    <input class="sell-form__input sell-form__input-img" type="file" name="image" id="image"
                        accept="image/*">
                </div>
                <p class="sell-form__error-message">
                    @error('image')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <h2 class="sell-form__sub-title">商品の詳細</h2>
            <div class="sell-form__group">
                <label class="sell-form__label" for="checkbox">カテゴリー</label>
                @foreach ($categories as $category)
                <input class="sell-form__input sell-form__input-checkbox" type="checkbox" name="categories[]"
                    id="{{ $category->id }}" value="{{ $category->id }}">
                <label for="{{ $category->id }}" class="sell-form__checkbox-label">{{ $category->content }}</label>
                @endforeach
                <p class="sell-form__error-message">
                    @error('category')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="sell-form__group">
                <label class="sell-form__label" for="item_condition">商品の状態</label>
                <select id="item_condition" name="condition" class="item_condition-select">
                    <option value="" disabled selected>選択してください</option>
                    <option value="1">良好</option>
                    <option value="2">目立った傷や汚れなし</option>
                    <option value="3">やや傷や汚れあり</option>
                    <option value="4">状態が悪い</option>
                </select>
                <p>
                    @error('condition')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <h2 class="sell-form__sub-title">商品名と説明</h2>
            <div class="sell-form__group">
                <label class="sell-form__label" for="name">商品名</label>
                <input class="sell-form__input" type="text" name="name" id="name" value="">
                <p>
                    @error('name')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="sell-form__group">
                <label class="sell-form__label" for="brand">ブランド名</label>
                <input class="sell-form__input" type="text" name="brand" id="brand">
                <p>
                    @error('brand')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="sell-form__group">
                <label class="sell-form__label" for="details">商品の説明</label>
                <textarea class="sell-form__input" name="details" id="details"></textarea>
                <p>
                    @error('details')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="sell-form__group">
                <label class="sell-form__label" for="price">販売価格</label>
                <div class="sell-form__over-div">
                    <input class="sell-form__input" type="text" name="price" id="price">
                </div>
                <p>
                    @error('price')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <input class="sell-form__btn btn" type="submit" value="更新する">
        </form>
    </div>
</div>
@endsection