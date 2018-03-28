<form id="form{{ $form->name }}" class="uk-form {{ $form->formClass }}" method="{{ $form->method }}"
      action="{{ $form->action }}" enctype="multipart/form-data">
    @foreach($form->rows as $key => $input)
        {!! $input !!}
    @endforeach
    <input type="hidden" name="page_title" value="">
    <input type="hidden" name="page_url" value="">
    <input type="hidden" name="page_id" value="">
    <input type="hidden" name="form_id" value="form{{ $form->name }}">
    @if($form->captcha) {!! app('captcha')->render(); !!} @endif
    {{ csrf_field() }}
</form>

@if(isset($jsValidation))
    {!! $jsValidation !!}
@endif