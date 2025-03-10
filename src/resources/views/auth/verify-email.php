@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('メール認証の確認') }}</div>

                <div class="card-body">
                    <p>{{ __('あなたのメールアドレスに確認メールを送信しました。メールボックスを確認し、確認リンクをクリックして認証を完了してください。') }}</p>

                    <p>
                        {{ __('確認メールが届かない場合は、以下のボタンをクリックして再送信できます。') }}
                    </p>

                    <!-- 再送信ボタン -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">{{ __('確認メールを再送信') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection