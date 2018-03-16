<form id="form{{ $form_id }}" class="{{ array_get($form, 'form_class') }} uk-form"
      method="{{ array_get($form, 'method', 'post') }}" action="{{ array_get($form, 'action', '/form/send') }}">
    @foreach($form['rows'] as $key => $input)
        @if(\View::exists('larrock::front.ContactBuilder.rows.'. $input['type']))
            @include('larrock::front.ContactBuilder.rows.'. $input['type'], ['row' => $input, 'name' => $key])
        @else
            @include('larrock::front.ContactBuilder.rows.input', ['row' => $input, 'name' => $key])
        @endif
    @endforeach
    <input type="hidden" name="page_title" value="">
    <input type="hidden" name="page_url" value="">
    <input type="hidden" name="page_id" value="">
    <input type="hidden" name="form_id" value="{{ $form_id }}">
    {{ csrf_field() }}
</form>

{!! $jsValidation !!}