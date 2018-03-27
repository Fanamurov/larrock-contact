@extends('larrock::admin.main')
@section('title') {{ $data->title }} || {{ $app->name }} admin @endsection

@section('content')
    <div class="container-head uk-margin-bottom">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-expand">
                {!! Breadcrumbs::render('admin.'. $app->name .'.edit', $data) !!}
            </div>
            <div class="uk-width-auto"></div>
        </div>
    </div>

    <p>Форма была отправлена {{ $data->created_at->format('d.m.Y H:s:i') }} [Статус: {{ $data->form_status }}]</p>
    <div class="ibox-content uk-margin-bottom uk-margin-large-top">
        {!! $emailData !!}
    </div>

    <div class="uk-grid buttons-save" uk-grid>
        <div class="uk-width-1-2">
            <form class="uk-form" action="/admin/{{ $app->name }}/{{ $data->id }}" method="post" id="test">
                <input name="_method" type="hidden" value="DELETE">
                <input name="id_connect" type="hidden" value="{{ $data->id }}">
                <input name="type_connect" type="hidden" value="{{ $app->name }}">
                <input name="place" type="hidden" value="material">
                {{ csrf_field() }}
                <button type="submit" class="uk-button uk-button-danger uk-button-large please_conform">Удалить</button>
            </form>
        </div>
        <div class="uk-width-1-2 uk-text-right"></div>
    </div>
@endsection