@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
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
<div class="purchase__content">
    <div class="purchase__content-detail">
        <div class="purchase__content-title">
            <div class="purchase__img">
                <img class="purchase__img-img" src="{{ $contact->image->img_url }}" alt="">
            </div>

            <div class="purchase__content-group">
                <div class="purchase__title">
                    <h1>{{ $contact['name'] }}</h1>
                </div>
                <div class="purchase__price">
                    <p class="purchase__price-integer">{{ $contact['price'] }}</p>
                </div>
            </div>
        </div>

        <div class="purchase__content-pay">
            <h3>支払い方法</h3>
            <select id="purchase__pay-select" class="purchase__pay-select" name="purchase__pay-select"
                onchange="updateContent()">
                <option value="">選択してください</option>
                <option value="1">コンビニ払い</option>
                <option value="2">カード支払い</option>
            </select>
        </div>

        <div class="purchase__content-address">
            <h3>配送先</h3>
            <form action="/purchase/address/{{ $contact['id'] }}">
                @csrf
                <input class="purchase-form__btn" type="submit" value="変更する">
            </form>
            <div class="purchase__content-address-detail">
                <p>〒 {{ $profile->post_code }}</p>
                <p>{{ $profile->address }}{{ $profile->building }}</p>
            </div>
        </div>
    </div>

    <div class="purchase-form">
        <form class="purchase-form__form" action="/payment/{{ $contact->id }}" method="get">
            @csrf
            <table class="purchase__status">
                <tr>
                    <td class="purchase__status-left">商品代金</td>
                    <td class="purchase__status-right">\{{ $contact['price'] }}</td>
                </tr>
                <tr>
                    <td class="purchase__status-left">支払い方法</td>
                    <td class="purchase__status-right purchase__status-changed">
                        <input type="text" readonly />
                    </td>
                </tr>
            </table>
            <input class="purchase-btn btn" type="submit" value="購入する">
        </form>
    </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>
@endsection