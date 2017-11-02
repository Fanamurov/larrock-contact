@extends('larrock::emails.template.header')
@extends('larrock::emails.template.body')

@section('content')
    <h1 style="color: #202020 !important;
    display: block;
    font-family: Arial, sans-serif;
    font-size: 26px;
    font-style: normal;
    font-weight: bold;
    line-height: 100%;
    letter-spacing: normal;
    margin-top: 0;
    margin-right: 0;
    margin-bottom: 10px;
    margin-left: 0;
    text-align: left;">{{ array_get($form['email'], 'subject', 'Отправлена форма с сайта '. env('SITE_NAME', env('APP_URL'))) }}</h1>
    @foreach($data as $key => $value)
        @if( !empty($value))
            <p style="font:14px/16px Calibri,Helvetica,Arial,sans-serif;">@lang('larrock::fields.'. $key): <strong>{{ $value }}</strong></p>
        @endif
    @endforeach
@endsection

@section('footer')
    @include('larrock::emails.template.footer')
@endsection