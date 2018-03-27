<?php

namespace Larrock\ComponentContact\Helpers;

trait MailableFormTrait
{
    /** @var bool|null */
    public $debugMail;

    /** @var array Какие поля отправленные формой не нужно обрабатывать в шаблоне письма */
    public $exceptRender = ['g-recaptcha-response', '_token', 'form_id', 'file'];

    /** @var string Шаблон для письма */
    public $mailTemplate = 'larrock::emails.formDefault';

    /** @var string Тема и заголовок письма */
    public $mailSubject = 'Форма отправлена';

    /** @var string Сообщение пользователю в интерфейсе об успешной отправке формы */
    public $messageSuccess;

    /** @var string Сообщение пользователю в интерфейсе о невозможности отправки формы */
    public $messageDanger;

    /** @var string Адрес отправителя письма */
    public $mailFromAddress;

    /** @var string Имя отправителя в письме */
    public $mailFromName;

    /**
     * Отрисовка тела шаблона письма вместо его отправки. Для дебага
     */
    public function setDebugMail()
    {
        $this->debugMail = TRUE;
    }

    /**
     * Какие поля ну нежно обрабатывать в шаблоне письма
     * @param array $exceptRender Массив названий полей формы
     */
    public function setExceptRender(array $exceptRender)
    {
        $this->exceptRender = array_merge($this->exceptRender, $exceptRender);
    }

    /**
     * Установка сообщения пользователю в интерфейсе об успешной отправке формы
     * @param string $message
     * @return $this
     */
    public function setMessageSuccess(string $message)
    {
        $this->messageSuccess = $message;
        return $this;
    }

    /**
     * Установка сообщения пользователю в интерфейсе о невозможности отправки формы
     * @param string $message
     * @return $this
     */
    public function setMessageDanger(string $message)
    {
        $this->messageDanger = $message;
        return $this;
    }

    /**
     * Уставновка шаблона для письма
     * @param string $template
     * @return $this
     */
    public function setMailTemplate(string $template)
    {
        $this->mailTemplate = $template;
        return $this;
    }

    /**
     * Установка заголовка и темы письма
     * @param string $subject
     * @return $this
     */
    public function setMailSubject(string $subject)
    {
        $this->mailSubject = $subject;
        return $this;
    }

    /**
     * Уставновка адреса для получения писем
     * @param string $address
     * @return MailableFormTrait
     */
    public function setMailFromAddress(string $address)
    {
        $this->mailFromAddress = $address;
        return $this;
    }

    /**
     * Установка имени отправителя в письме
     * @param string $name
     * @return $this
     */
    public function setMailFromName(string $name)
    {
        $this->mailFromName = $name;
        return $this;
    }

    /**
     * @param $request
     * @return string
     * @throws \Throwable
     */
    public function renderMail($request)
    {
        if(view()->exists($this->mailTemplate)){
            return view($this->mailTemplate, ['form' => $this, 'data' => $request])->render();
        }
        throw new \Exception('Шаблон для письма формы '. $this->name .' не определен');
    }
}