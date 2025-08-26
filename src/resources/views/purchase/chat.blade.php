@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css')}}">
@endsection

@section('content')
<div class="chat-container">
    <div class="chat-sidebar">
        <h3 class="chat-sidebar-title">その他の取引</h3>
        <ul class="chat-list">
            @foreach($other_trades as $trade)
            <li class="chat-item">
                <a href="{{ route('purchase.chat', ['payment_id' => $trade->id]) }}">
                    {{ $trade->item->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="chat-main">
        <div class="chat-header">
            <div class="chat-user">
                <img src="{{ asset($partner->image->img_url) }}" class="chat-user-img">
                <span class="chat-user-name">「{{ $partner->name }}」さんとの取引画面</span>
            </div>

            @if($role === 'buyer')
            <form action="{{ route('purchase.complete', ['payment_id' => $payment->id]) }}" method="post">
                @csrf
                <button type="submit" class="chat-complete-btn btn">取引を完了する</button>
            </form>
            @endif
        </div>

        <div class="chat-item-detail">
            <img src="{{ asset($payment->item->image->img_url )}}" class="chat-item-img">
            <div class="chat-item-info">
                <p class="chat-item-name">{{ $payment->item->name }}</p>
                <p class="chat-item-price">¥{{ number_format($payment->item->price) }}</p>
            </div>
        </div>

        <!-- チャットログ -->
        <div class="trade-chat">
            @foreach($messages as $message)
            @php
            $isMine = $message->user_id === Auth::id();
            $avatar = optional($message->user->image)->img_url ?? asset('img/user.png');
            $messageImage = optional($message->image)->img_url ?? null;
            @endphp
            @if($isMine) <div class="chat-message chat-self">
                <div class="chat-content">
                    <div class="chat-mydata"> <span>{{ $message->user->name }}</span> <img src="{{ asset($avatar) }}"
                            class="chat-user-img"> </div> <!-- 編集フォーム -->
                    <form action="{{ route('messages.update', $message->id) }}" method="post" class="chat-edit-form">
                        @csrf
                        @method('PATCH') <input type="text" name="message" value="{{ $message->message }}"
                            class="chat-edit-input">
                        @if($message->image)
                        <img src="{{ asset('storage/' . $message->image->img_url) }}" alt="添付画像"
                            style="max-width:200px; margin-top:6px;">
                        @endif
                        <div class="chat-actions-wrapper"> <button type="submit">更新</button>
                    </form>

                    <!-- 削除フォーム -->
                    <form action="{{ route('messages.destroy', $message->id) }}" method="post"
                        onsubmit="return confirm('削除しますか？');" class="delete-form"> @csrf @method('DELETE') <button
                            type="submit">削除</button> </form>
                </div>
            </div>
        </div>

        @else

        <div class="chat-message chat-partner">
            <div class="chat-mydata">
                <img src="{{ asset($avatar) }}" class="chat-user-img">
                <span class="chat-username">{{ $message->user->name }}</span>
            </div>
            <div class="chat-content">
                <p class="chat-text">{{ $message->message }}</p>
                @if($message->image)
                <img src="{{ asset('storage/' . $message->image->img_url) }}" alt="添付画像"
                    style="max-width:200px; margin-top:6px;">
                @endif
            </div>
        </div>
        @endif
        @endforeach
    </div>

    <form action="{{ route('messages.store', ['payment_id' => $payment->id]) }}" method="POST"
        enctype="multipart/form-data" class="chat-input-area">
        @csrf
        <div class="chat-input-area">
            <input type="text" class="chat-input" name="message" value="{{ old('message') ?? '' }}"
                placeholder="取引メッセージを記入してください" data-payment-id="{{ $payment->id }}" @if($chatCompleted && !$reviewed)
                disabled @endif>
            <label class="chat-image-btn" @if($chatCompleted && !$reviewed) style="pointer-events:none; opacity:0.5;"
                @endif>
                画像を追加
                <input type="file" name="image" hidden>
            </label>
            <button type="submit" class="chat-send-btn" @if($chatCompleted && !$reviewed) disabled @endif>
                <img src="{{ asset('img/inputbutton.png') }}" alt="送信" class="chat-send-img">
            </button>
        </div>
    </form>
    @if ($errors->any())
    <div class="mt-2">
        @foreach ($errors->all() as $error)
        <p class="text-red-500 text-sm">{{ $error }}</p>
        @endforeach
    </div>
    @endif
</div>
@if($showModal)
<div class="modal-overlay">
    <div class="modal modal-rating">
        <h2 class="modal-title">取引が完了しました</h2>
        <hr class="modal-divider">

        <p class="modal-text">今回の取引相手はどうでしたか？</p>

        <form action="{{ route('reviews.store', ['payment_id' => $payment->id]) }}" method="post" class="review-form">
            @csrf
            <div class="star-rating">
                @for($i = 1; $i <= 5; $i++) <span class="star" data-value="{{ $i }}">★</span>
                    @endfor
            </div>
            <hr class="modal-divider">

            <input type="hidden" name="rating" id="rating">
            <div class="btn-wrapper">
                <button type="submit" class="btn btn-submit">送信する</button>
            </div>
        </form>
    </div>
</div>
@endif



</div>
@endsection

@section('scripts')
<script src="{{ mix('js/chat.js') }}"></script>
<script src="{{ mix('js/evaluation.js') }}"></script>
@endsection