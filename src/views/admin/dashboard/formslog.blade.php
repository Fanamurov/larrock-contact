<div id="dashboard-blocks" class="dashboard-item uk-width-small-1-2 uk-width-medium-1-4">
    <div class="uk-panel uk-alert">
        <p class="uk-h3"><a href="/admin/{{ $component->name }}">{{ $component->title }}</a></p>
        @if(count($data) > 0)
            <ul class="uk-list">
                @foreach($data as $value)
                    <li><a href="/admin/contact/{{ $value->id }}/edit">{{ $value->title }}</a>
                        @if($value->form_status === 'Новая')
                            <span class="uk-badge uk-badge-warning">{{ \Carbon\Carbon::parse($value->created_at)->format('d M') }} {{ $value->form_status }}</span>
                        @else
                            <span class="uk-badge uk-badge-notification">{{ \Carbon\Carbon::parse($value->updated_at)->format('d M') }} {{ $value->form_status }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p>Лог форм пуст</p>
        @endif
    </div>
</div>