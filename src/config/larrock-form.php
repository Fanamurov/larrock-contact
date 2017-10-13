<?php

$rule_captcha = ['g-recaptcha-response' => ''];
if(env('INVISIBLE_RECAPTCHA_SITEKEY')){
    $rule_captcha = ['g-recaptcha-response' => 'required|captcha'];
}

return [
    'backphone' => [
        'name' => 'Заказать звонок',
        'view' => 'larrock::front.modules.forms.backphone',
        'emailTemplate' => 'larrock::emails.formDefault',

        'emailFrom' => 'no-reply@'. array_get($_SERVER, 'HTTP_HOST'),
        'emailDataExcept' => ['g-recaptcha-response', '_token', 'agree', 'form'],
        'emailSuccessMessage' => 'Отправлена форма заявки '. env('SITE_NAME', env('APP_URL')),
        'emailSubject' => 'Отправлена форма заявки '. env('SITE_NAME', env('APP_URL')),
        'emails' => env('MAIL_TO_ADMIN', 'robot@martds.ru'),
        'rules' => [
            'name' => 'required',
            'contact' => 'required',
            'agree' => 'required',
            $rule_captcha
        ]
    ]
];