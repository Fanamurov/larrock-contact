<div class="uk-margin-bottom uk-width-1-1 uk-width-1-4@m">
    <h4 class="panel-p-title"><a href="/admin/{{ $component->name }}">{{ $component->title }}</a></h4>
    <div class="uk-card uk-card-default uk-card-small">
        <div class="uk-card-body">
            @if(count($data) > 0)
                <ul class="uk-list">
                    @foreach($data as $value)
                        <li>
                            <a href="/admin/{{ $component->name }}/{{ $value->id }}/edit">{{ $value->title }}</a>
                            @if($value->form_status === 'Новая')
                                <span class="uk-label uk-label-warning">{{ \Carbon\Carbon::parse($value->created_at)->format('d M') }} {{ $value->form_status }}</span>
                            @else
                                <span class="uk-label uk-label-notification">{{ \Carbon\Carbon::parse($value->updated_at)->format('d M') }} {{ $value->form_status }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Лог форм пуст</p>
            @endif
        </div>
    </div>
</div>