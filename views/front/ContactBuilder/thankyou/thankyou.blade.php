@extends('vendor.larrock.front.main')
@section('title') Спасибо за обращение к нашей компании. Наши менеджеры свяжутся с Вами. @endsection

@section('content')
    <div class="page-thankyou">
        <div class="page_description">{!! $spasibo_text !!}</div>
    </div>
@endsection