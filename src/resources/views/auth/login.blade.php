@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="login-form">
    <h2 class="login-form__heading content__heading">ログイン</h2>
    <div class="login-form__inner">
        <form class="login-form__form" action="/login" method="post">
            @csrf
            @error('no_data')
            <p>{{ $message }}</p>
            @enderror
            <div class="login-form__group">
                <label class="login-form__label" for="name">ユーザー名/メールアドレス</label>
                <input class="login-form__input" type="text" name="name" id="name">
                <p class="login-form__error-message">
                    @error('name')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="login-form__group">
                <label class="login-form__label" for="password">パスワード</label>
                <input class="login-form__input" type="password" name="password" id="password">
                <p>
                    @error('password')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <input class="login-form__btn btn" type="submit" value="ログインする">
            <div class="login-form__link">
                <a href="/register">会員登録はこちら</a>
            </div>
        </form>
    </div>
</div>
@endsection