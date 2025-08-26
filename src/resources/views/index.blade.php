@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="index__header">
    <form class="index__header__form-recommendation" action="/" method="get">
        @csrf
        <input class="index__header__link-recommendation" type="submit" value="おすすめ">
    </form>

    <form class="index__header__form-mylist" action="/" method="post">
        @csrf
        <input type="hidden" name="page" value="mylist">
        <input class="index__header__link-mylist" type="submit" value="マイリスト">
    </form>
</div>

<div class="index__content">
    @foreach ($contacts as $contact)
    <div class="index__form">
        <form action="/item/{{$contact->id}}" method="get">
            <input class="index__form__image-id" type="hidden" value="{{$contact->id}}">
            <input class="index__form__image" type="image" src="{{ $contact->image->img_url }}">
            <input class="index-form__item-name" type="submit" value="{{$contact->name}}">
        </form>
    </div>
    @endforeach

    <div class="index__form__paginate">
        {{ $contacts->links() }}
    </div>
</div>
@endsection