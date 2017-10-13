<form id="form-backphone" class="form-contact uk-form" method="post" action="/forms/send">
    <p class="uk-h3 uk-text-center">Заказать звонок</p>
    <div class="uk-form-row">
        <input type="text" id="form-contact-name" name="name" class="uk-form-width-large" placeholder="Как к Вам обращаться">
    </div>
    <div class="uk-form-row">
        <input type="text" id="form-contact-contact" name="contact" class="uk-form-width-large" placeholder="Ваш телефон">
    </div>
    <div class="uk-form-row">
        <label class="uk-form-label agree-label">
            <input type="checkbox" name="agree"> <span>Я согласен на обработку персональных данных</span>
        </label>
    </div>
    <div class="uk-form-row uk-text-right">
        @if(env('INVISIBLE_RECAPTCHA_SITEKEY'))
            @captcha()
        @endif
        {{ csrf_field() }}
        <input type="hidden" name="form" value="backphone">
        <button type="submit" class="uk-button uk-button-primary">Перезвонить мне</button>
    </div>
</form>
{!! JsValidator::formRequest('Larrock\ComponentContact\Requests\BackphoneRequest', '#form-backphone')->render() !!}