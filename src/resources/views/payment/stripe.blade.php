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
        <div id="stripe-element"></div>
        <div id="stripe-errors" role="alert"></div>
        <button type="submit" class="payment__btn">支払いを完了する</button>
    </form>
</div>

<input type="hidden" id="stripe-public-key" value="{{ config('services.stripe.public') }}">
<input type="hidden" id="client-secret" value="{{ $clientSecret }}">
@endsection

@section('js')
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ mix('js/app.js') }}"></script>
@endsection