@extends('larrock::emails.template.body')

@section('content')
    {!! $data !!}
@endsection

@section('footer')
    @include('larrock::emails.template.footer')
@endsection