<form id="form-contact" class="form-contact uk-form" method="post" action="/forms/contact">
    <p class="uk-h3">Форма заявки</p>
    <div class="uk-form-row">
        <label for="form-contact-name" class="uk-form-label">Как к Вам обращаться:</label>
        <input type="text" id="form-contact-name" name="name" class="uk-form-width-large">
    </div>
    <div class="uk-form-row">
        <label for="form-contact-contact" class="uk-form-label">Email или телефон:</label>
        <input type="text" id="form-contact-contact" name="contact" class="uk-form-width-large">
    </div>
    <div class="fuk-form-row">
        <textarea name="comment" id="form-contact-comment" placeholder="Комментарий"></textarea>
    </div>
    <div class="uk-form-row">
        <label class="uk-form-label agree-label">
            <input type="checkbox" name="agree"> Я согласен на обработку персональных данных
        </label>
    </div>
    <div class="uk-form-row uk-text-right">
        {{ csrf_field() }}
        <button type="submit" class="uk-button uk-button-large uk-button-primary">Отправить</button>
    </div>
</form>
{!! JsValidator::formRequest('Larrock\ComponentContact\Requests\ContactRequest', '#form-contact')->render() !!}