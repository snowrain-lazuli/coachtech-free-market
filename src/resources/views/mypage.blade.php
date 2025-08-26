@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage__account">
    <!-- 上段：アカウント情報 -->
    <div class="mypage__account-top">

        <div class="mypage__account-left">
            <img class="mypage__account-img" src="{{ asset($profiles->image->img_url) }}">

            <div class="mypage__account-userinfo">
                <span class="mypage__account-username">{{ $profiles->name }}</span>
                @if($averageRating > 0)
                <div class="mypage__account-rating" data-rating="{{ $averageRating}}">
                    <div class="stars-outer">
                        <div class="stars-inner"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <form action="/mypage/profile" method="get">
            @csrf
            <input class="mypage__account-btn" type="submit" value="プロフィールを編集">
        </form>
    </div>

    <!-- 下段：ページ切替（文字ボタン表示） -->
    <div class="mypage__account-tabs">
        <form action="/mypage" method="post">
            @csrf
            <input type="hidden" name="page" value="sell">
            <button type="submit" class="mypage__account-tab-btn">出品した商品</button>
        </form>

        <form action="/mypage" method="post">
            @csrf
            <input type="hidden" name="page" value="buy">
            <button type="submit" class="mypage__account-tab-btn">購入した商品</button>
        </form>

        <form action="/mypage" method="post">
            @csrf
            <input type="hidden" name="page" value="trade">
            <button type="submit" class="mypage__account-tab-btn">取引中の商品{{ $total_unread }}</button>
        </form>
    </div>

    <!-- 下線 -->
    <div class="mypage__account-divider"></div>
</div>




<div class="mypage__content">
    @if (!empty($contacts))
    @foreach ($contacts as $contact)
    @if ($page === 'trade')
    @foreach ($contact->payments as $payment)
    <div class="mypage__form">
        <form action="{{ route('purchase.chat', ['payment_id' => $payment->id]) }}" method="get">
            <div class="image-wrapper">
                @if($contact->unread_count> 0)
                <span class="image-badge">{{ $contact->unread_count }}</span>
                @endif
                <input class="mypage__form__image-id" type="hidden" value="{{ $contact->id }}">
                <input class="mypage__form__image" type="image" src="{{ $contact->image->img_url }}">
                <input class="mypage-form__item-name" type="submit" value="{{ $contact->name }}">
            </div>
        </form>
    </div>
    @endforeach
    @else
    <div class="mypage__form">
        <form action="/item/{{ $contact->id }}" method="get">
            <div class="image-wrapper">
                @if($contact->unread_count > 0)
                <span class="image-badge">{{ $contact->unread_count }}</span>
                @endif
                <input class="mypage__form__image-id" type="hidden" value="{{ $contact->id }}">
                <input class="mypage__form__image" type="image" src="{{ $contact->image->img_url }}">
                <input class="mypage-form__item-name" type="submit" value="{{ $contact->name }}">
            </div>
        </form>
    </div>
    @endif
    @endforeach
    @endif
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/mypage.js') }}"></script>
@endsection