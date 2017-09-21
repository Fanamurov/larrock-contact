<h1 style="font:26px/32px Calibri,Helvetica,Arial,sans-serif;">{{ config('larrock-form.'. Request::get('form') .'.emailSubject') }}</h1>
@foreach($data as $key => $value)
    <p style="font:14px/16px Calibri,Helvetica,Arial,sans-serif;"><strong>@lang('larrock::fields.'. $key):</strong> {{ $value }}</p>
@endforeach