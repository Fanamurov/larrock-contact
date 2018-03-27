<form id="form{{ $form->name }}" class="uk-form {{ $form->formClass }}"
      method="{{ $form->method }}" action="{{ $form->action }}">
    @foreach($form->rows as $key => $input)
        {!! $input !!}
    @endforeach
    <input type="hidden" name="page_title" value="">
    <input type="hidden" name="page_url" value="">
    <input type="hidden" name="page_id" value="">
    <input type="hidden" name="form_id" value="form{{ $form->name }}">
    {{ csrf_field() }}
</form>

@if(isset($jsValidation))
    {!! $jsValidation !!}
@endif