@extends('larrock::admin.main')
@section('title') {{ $data->title }} || {{ $app->name }} admin @endsection

@section('content')
    <link href="/_assets/bower_components/pickadate/lib/themes/default.css" rel="stylesheet">
    <link href="/_assets/bower_components/pickadate/lib/themes/default.date.css" rel="stylesheet">
    <div class="container-head uk-margin-bottom">
        <div class="add-panel uk-margin-bottom uk-text-right">
            <a class="uk-button" href="#modal-help" data-uk-modal="{target:'#modal-help'}"><i class="uk-icon-question"></i></a>
        </div>
        <div id="modal-help" class="uk-modal">
            <div class="uk-modal-dialog">
                <a class="uk-modal-close uk-close"></a>
                <p>{{ $app->description }}</p>
            </div>
        </div>
        <div class="uk-clearfix"></div>
        {!! Breadcrumbs::render('admin.'. $app->name .'.edit', $data) !!}
    </div>

    <div class="ibox-content uk-margin-bottom uk-margin-large-top">
        {!! $emailData !!}
    </div>

    <ul class="uk-tab uk-margin-large-top" data-uk-switcher="{connect:'#tab-content, #tab-content-plugins'}">
        @foreach($app->tabs as $tabs_key => $tabs_value)
            <li class="@if($loop->first) uk-active @endif">
                <a href="">{{ $tabs_value }}</a>
            </li>
            @if($loop->first && $app->plugins_backend)
                @if(array_key_exists('images', $app->plugins_backend))
                    @include('larrock::admin.admin-builder.plugins.images.tab-title')
                @endif
                @if(array_key_exists('files', $app->plugins_backend))
                    @include('larrock::admin.admin-builder.plugins.files.tab-title')
                @endif
            @endif
        @endforeach
    </ul>

    <div class="ibox-content">
        <form id="edit-form-build" class="validate uk-form uk-form-stacked" action="/admin/{{ $app->name }}/{{ $data->id }}" method="POST" novalidate="novalidate">
            <ul id="tab-content" class="uk-switcher uk-margin">
                @foreach($app->tabs_data as $tabs_key => $tabs_value)
                    <li id="tab{{ $tabs_key }}">
                        <div class="uk-grid">{!! $tabs_value !!}</div>
                    </li>
                    @if($loop->first && $app->plugins_backend) <li></li><li></li> @endif
                @endforeach
            </ul>

            <div class="uk-align-right">
                <input name="_method" type="hidden" value="PUT">
                <input name="type_connect" type="hidden" value="{{ $app->name }}">
                <input name="id_connect" type="hidden" value="{{ $data->id }}">
                {{ csrf_field() }}
                <button type="submit" class="uk-button uk-button-primary uk-button-large uk-hidden" form="edit-form-build">Сохранить</button>
            </div>
            <div class="uk-clearfix"></div>
        </form>

        @if($app->plugins_backend)
            <ul id="tab-content-plugins" class="uk-switcher uk-margin">
                @foreach($app->tabs as $tabs_key => $tabs_value) <li></li>
                @if($loop->first && $app->plugins_backend)
                    @if(array_key_exists('images', $app->plugins_backend))
                        @include('larrock::admin.admin-builder.plugins.images.tab-data')
                    @endif
                    @if(array_key_exists('files', $app->plugins_backend))
                        @include('larrock::admin.admin-builder.plugins.files.tab-data')
                    @endif
                @endif
                @endforeach
            </ul>
        @endif
    </div>

    <div class="uk-grid uk-margin-top buttons-save">
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
        <div class="uk-width-1-2 uk-text-right">
            <button type="submit" class="uk-button uk-button-primary uk-button-large" form="edit-form-build">Сохранить</button>
        </div>
    </div>

    <div id="process-modal" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>
            <p class="text-process-modal"></p>
        </div>
    </div>
@endsection