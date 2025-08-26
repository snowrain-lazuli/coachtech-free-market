@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/stripe.css') }}">
@endsection

@section('content')
<div class="payment__header">
    <h2>支払い情報の入力</h2>
    <p>商品代金: ¥{{ number_format($contact->price) }}</p>
</div>

<div class="payment__form">
    <form id="payment-form">
        @csrf
        <div class="card-wrapper">
            <table class="card-table">
                <tr>
                    <td class="label-cell">カード情報</td>
                    <td class="input-cell">
                        <div id="stripe-element"></div>
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">カード名義</td>
                    <td class="input-cell">
                        <input type="text" id="cardholder-name">
                    </td>
                </tr>
            </table>
        </div>

        <div id="stripe-errors" role="alert"></div>
        <button type="submit" class="payment__btn">支払いを完了する</button>
    </form>
</div>

<input type="hidden" id="stripe-public-key" value="{{ config('services.stripe.key') }}">
<input type="hidden" id="item-id" value="{{ $contact->id }}">
@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ mix('js/stripe.js') }}"></script>
@endsection