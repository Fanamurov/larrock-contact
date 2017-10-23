<?php

$rule_captcha = ['g-recaptcha-response' => ''];
if(env('INVISIBLE_RECAPTCHA_SITEKEY')){
    $rule_captcha = ['g-recaptcha-response' => 'required|captcha'];
}

return [
    'backphone' => [
        'name' => 'Заказать звонок', //название формы
        'view' => 'larrock::front.modules.forms.backphone', //шаблон формы для фронта
        'emailTemplate' => 'larrock::emails.formDefault', //шаблон письма

        'emailFrom' => 'no-reply@'. array_get($_SERVER, 'HTTP_HOST'), //email "от кого"
        'emailDataExcept' => ['g-recaptcha-response', '_token', 'agree', 'form'], //что не передавать в шаблон email
        'emailSuccessMessage' => 'Отправлена форма заявки '. env('SITE_NAME', env('APP_URL')), //сообщение об успешной отправке
        'emailSubject' => 'Отправлена форма заявки '. env('SITE_NAME', env('APP_URL')), //тема письма
        'emails' => env('MAIL_TO_ADMIN', 'robot@martds.ru'), //кому присылать письма
        'rules' => [
            'name' => 'required',
            'contact' => 'required',
            'agree' => 'required',
            $rule_captcha
        ], //правила валидации
        'forms_log' => TRUE, //сохранять ли письма в БД
    ],

    'forms_log' => TRUE, //сохранять ли письма в БД (глобальная установка)
];