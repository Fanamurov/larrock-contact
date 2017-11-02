<?php

$rule_captcha = ['g-recaptcha-response' => ''];
if(env('INVISIBLE_RECAPTCHA_SITEKEY')){
    $rule_captcha = ['g-recaptcha-response' => 'required|captcha'];
}

return [
    /*'minimal' => [
        'rows' => [ //поля формы
            'tel' => [
                'type' => 'tel',
                'title' => 'Телефон',
            ],
            'submit' => [
                'type' => 'submit',
                'title' => 'Получить коммерческое предложение'
            ]
        ]
    ],*/
    'backphone' => [ //форма
        'name' => 'Подайте заявку', //название формы
        'rows' => [ //поля формы
            'email' => [ //поле
                'type' => 'input', //тип поля (input,tel,email, select и т.д.)
                'title' => 'Email (не обязательно)', //Заголовок поля (label)
            ],
            'tel' => [
                'type' => 'tel',
                'title' => 'Телефон',
            ],
            'agree' => [
                'type' => 'checkbox',
                'title' => 'Я согласен на обработку персональных данных',
            ],
            'submit' => [
                'type' => 'submit',
                'title' => 'Получить коммерческое предложение'
            ]
        ],

        'email' => [
            'dataExcept' => ['agree'], //что не передавать в шаблон email
            'successMessage' => 'Отправлена форма заявки '. env('SITE_NAME', env('APP_URL')), //сообщение об успешной отправке
            'subject' => 'Отправлена форма заявки '. env('SITE_NAME', env('APP_URL')), //тема письма
            'to' => 'fanamurov@ya.ru', //кому присылать письма, через запятую (по-умолчанию: env('MAIL_TO_ADMIN'))
            'template' => 'larrock::emails.formDefault', //шаблон письма
        ],

        'rules' => [
            'email' => 'email',
            'tel' => 'required',
            'agree' => 'required',
            $rule_captcha
        ], //правила валидации

        'form_class' => 'form_backphone', //css-класс формы

        'redirect' => '/test', //куда перенаправлять после отправки письма
        'debugMail' => FALSE, //Отрисовка тела шаблона письма вместо его отправки. Для дебага
        'render' => TRUE //Если FALSE, то не обрабатывается ContactCreateTemplate Middleware
    ],

    /*
     * Пример формы со всеми настройками:
     'backphone' => [ //форма
        'name' => 'Подайте заявку', //название формы
        //'view' => 'larrock::front.modules.forms.backphone', //шаблон письма (по-умолчанию: larrock::emails.formDefault)
        'rows' => [ //поля формы
            'email' => [ //поле
                'type' => 'input', //тип поля (input,tel,email, select и т.д.)
                'title' => 'Email (не обязательно)', //Заголовок поля (label)
                'css_class' => 'input', //css-класс для поля,
                'css_class_row' => 'row', //css-класс для всего блока с полем
            ],
            'tel' => [
                'type' => 'tel',
                'title' => 'Телефон',
            ],
            'agree' => [
                'type' => 'checkbox',
                'title' => 'Я согласен на обработку персональных данных',
            ],
            'submit' => [
                'type' => 'submit',
                'title' => 'Получить коммерческое предложение'
            ]
        ],

        'email' => [
            'from' => 'no-reply@'. array_get($_SERVER, 'HTTP_HOST'), //email "от кого", по-умолчанию env('MAIL_FROM_ADDRESS')
            'dataExcept' => ['agree'], //что не передавать в шаблон email
            'successMessage' => 'Отправлена форма заявки '. env('SITE_NAME', env('APP_URL')), //сообщение об успешной отправке
            'subject' => 'Отправлена форма заявки '. env('SITE_NAME', env('APP_URL')), //тема письма
            'to' => 'fanamurov@ya.ru', //кому присылать письма, через запятую (по-умолчанию: env('MAIL_TO_ADMIN'))
            'from_name' => 'Имя адресата', //от кого присылать письма, по-умолчанию: MAIL_FROM_NAME
            'template' => 'larrock::emails.formDefault', //шаблон письма
        ],

        'rules' => [
            'email' => 'email',
            'tel' => 'required',
            'agree' => 'required',
            $rule_captcha
        ], //правила валидации

        //'form_class' => 'form_backphone', //css-класс формы

        'forms_log' => FALSE, //сохранять ли письма в БД

        'action' => '/form/send', //form action
        'method' => 'post', //form method

        'redirect' => '/test' //куда перенаправлять после отправки письма

        'debugMail' => TRUE, //Отрисовка тела шаблона письма вместо его отправки. Для дебага
        'render' => TRUE //Если FALSE, то не обрабатывается ContactCreateTemplate Middleware
    ],
     */

    'forms_log' => TRUE, //сохранять ли письма в БД (глобальная установка)
];