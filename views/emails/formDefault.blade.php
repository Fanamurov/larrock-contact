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
    text-align: left;">{{ $form->mailSubject }}</h1>
    @foreach($data as $key => $value)
        @if( !empty($value) && \is_string($value))
            <p style="font:14px/16px Calibri,Helvetica,Arial,sans-serif;">{{ $form->rows[$key]->title }}: <strong>{{ $value }}</strong></p>
        @endif
        @if( !empty($value) && \is_array($value))
            <p style="font:14px/16px Calibri,Helvetica,Arial,sans-serif;">{{ $form->rows[$key]->title }}: <strong>@foreach($value as $val){{ $val }}@if( !$loop->last), @endif @endforeach</strong></p>
        @endif
    @endforeach

    @if($uploaded_files  && \count($uploaded_files) > 0)
        @foreach($uploaded_files as $key => $file)
            @if(\is_array($file) && \count($file) > 0)
                <p style="font:14px/16px Calibri,Helvetica,Arial,sans-serif;">{{ $form->rows[$key]->title }}:</p>
                @foreach($file as $file_item)
                    <a href="{{ $file_item }}" target="_blank">{{ $file_item }}</a>
                @endforeach
            @endif
        @endforeach
    @endif
@endsection

@section('footer')
    @include('larrock::emails.template.footer')
@endsection