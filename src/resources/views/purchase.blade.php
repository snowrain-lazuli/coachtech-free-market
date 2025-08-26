@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase__content">
    <div class="purchase__content-detail">
        <div class="purchase__content-title">
            <div class="purchase__img">
                <img class="purchase__img-img" src="{{ asset($contact->image->img_url) }}" alt="">
            </div>
            <div class="purchase__content-group">
                <div class="purchase__title">
                    <h1>{{ $contact['name'] }}</h1>
                </div>
                <div class="purchase__price">
                    <p class="purchase__price-integer">&yen;{{ $contact['price'] }}</p>
                </div>
            </div>
        </div>

        <div class="purchase__content-pay">
            <h3>支払い方法</h3>
            <select id="purchase__pay-select">
                <option value="">選択してください</option>
                <option value="1">コンビニ払い</option>
                <option value="2">カード支払い</option>
            </select>
        </div>

        <div class="purchase__content-address">
            <h3>配送先</h3>
            <form action="{{ route('purchase.address', ['item_id' => $contact->id]) }}">
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
        <form id="purchase-form" action="{{ route('purchase.post', ['item_id' => $contact->id]) }}" method="post"
            data-item-id="{{ $contact->id }}">
            @csrf
            <input type="hidden" name="payment_method" id="payment-method-hidden">
            <table class="purchase__status">
                <tr>
                    <td class="purchase__status-left">商品代金</td>
                    <td class="purchase__status-right">&yen;{{ $contact['price'] }}</td>
                </tr>
                <tr>
                    <td class="purchase__status-left">支払い方法</td>
                    <td class="purchase__status-right purchase__status-changed">
                        <input type="text" readonly id="payment-method-display">
                    </td>
                </tr>
            </table>
            <input class="purchase-btn btn" type="submit" value="購入する">
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/purchase.js') }}"></script>
@endsection