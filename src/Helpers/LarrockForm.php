<?php

namespace Larrock\ComponentContact\Helpers;

use Illuminate\Support\Collection;
use Larrock\Core\Helpers\FormBuilder\FBElement;

class LarrockForm
{
    use MailableFormTrait;

    /** @var string Ключ формы */
    public $name;

    /** @var string Человеческое имя для формы */
    public $title;

    /** @var string form action */
    public $action;

    /** @var string form method */
    public $method = 'post';

    /** @var Collection|bool Коллекция полей из FormBuilder */
    public $rows;

    /** @var string|bool css-класс для формы */
    public $formClass;

    /** @var bool|string Куда перенаправлять после отправки письма */
    public $redirect;

    /** @var bool|null */
    public $isRender = TRUE;

    /** @var bool|null Логировать данные отправленных через форму */
    public $formLog = TRUE;

    /** @var bool|null Кастомный шаблон для формы */
    public $template = 'larrock::front.ContactBuilder.form';

    /** @var bool|null Использовать ли captcha */
    public $captha;

    /** @var null|array Правила валидации формы */
    public $valid;

    /**
     * LarrockForm constructor.
     * @param string $name Ключ формы
     * @param string $title Человеческое название формы
     */
    public function __construct(string $name, string $title)
    {
        $this->name = $name;
        $this->title = $title;
        $this->action = '/form/send/'. $this->name;
        $this->messageSuccess = 'Форма отправлена. '. env('SITE_NAME', env('APP_URL'));
        $this->messageDanger = 'Форма не отправлена. '. env('SITE_NAME', env('APP_URL'));
        $this->mailSubject = $this->title .' '. env('SITE_NAME', env('APP_URL'));
        $this->mailFromName = env('SITE_NAME');
        $this->mailFromAddress = env('MAIL_FROM_ADDRESS');
    }

    /**
     * Установка form action
     * @param string $typeAction
     */
    public function setAction(string $typeAction)
    {
        $this->action = $typeAction;
    }

    /**
     * Установка form method
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     * Установка css-класса для формы
     * @param string $cssClass
     */
    public function setFormClass(string $cssClass)
    {
        $this->formClass = $cssClass;
    }

    /**
     * Установка url куда перенаправлять после отправки письма
     * @param $url
     */
    public function setRedirect($url)
    {
        $this->redirect = $url;
    }

    /**
     * Не обрабатывать через ContactCreateTemplate Middleware
     */
    public function setNotRender()
    {
        $this->isRender = null;
    }

    /**
     * Не логировать данные отправленных через форму
     */
    public function setNotFormLog()
    {
        $this->formLog = TRUE;
    }

    /**
     * Установка view для формы
     * @param string $view
     */
    public function setView(string $view)
    {
        $this->view = $view;
    }

    /**
     * Уставнока каптчи
     */
    public function setCaptcha()
    {
        $this->captha = TRUE;
    }

    /**
     * Добавление к форме нового поля
     * @param FBElement $FBElement
     * @return $this
     */
    public function setRow(FBElement $FBElement)
    {
        $this->rows[$FBElement->name] = $FBElement;
        $this->setValid($FBElement);
        return $this;
    }

    /**
     * Добавление новых правил валидации из полей
     * @param FBElement $FBElement
     * @return array|null
     */
    protected function setValid(FBElement $FBElement)
    {
        if($FBElement->valid){
            $this->valid[$FBElement->name] = $FBElement->valid;
        }
        return $this->valid;
    }

    /**
     * Создание объекта js-валидации
     * @return \Proengsoft\JsValidation\JavascriptValidator
     */
    public function makeJsValidation()
    {
        if(\is_array($this->valid)){
            return \JsValidator::make($this->valid, [], [], '#form'. $this->name);
        }
        return null;
    }

    /**
     * Рендеринг формы
     * @return string
     * @throws \Throwable
     */
    public function __toString()
    {
        if(view()->exists($this->template)){
            return view($this->template, ['form' => $this, 'jsValidation' => $this->makeJsValidation()])->render();
        }
        return 'Шаблон для формы '. $this->name .'->'. $this->template .' не найден';
    }
}