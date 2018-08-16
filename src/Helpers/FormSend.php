<?php

namespace Larrock\ComponentContact\Helpers;

use Mail;
use Validator;
use Illuminate\Http\Request;
use Larrock\Core\Helpers\MessageLarrock;
use Larrock\ComponentContact\Models\FormsLog;
use Larrock\Core\Helpers\FormBuilder\FormFile;
use Larrock\Core\Helpers\FormBuilder\FormButton;

class FormSend
{
    /**
     * Валидация данных формы.
     *
     * @param LarrockForm $form
     * @param Request $request
     * @return $this|bool
     */
    public function validateForm($form, Request $request)
    {
        if ($form->valid) {
            $validator = Validator::make($request->all(), $form->valid);
            if ($validator->fails()) {
                return $validator;
            }
        }

        return true;
    }

    /**
     * Загрузка файла из формы.
     *
     * @param LarrockForm $form
     * @param Request $request
     * @return null|array
     * @throws \Symfony\Component\HttpFoundation\File\Exception\FileException
     */
    public function uploadFile(LarrockForm $form, Request $request)
    {
        if (\is_array($form->rows)) {
            $uploaded_files = [];
            foreach ($form->rows as $row) {
                if ($row instanceof FormFile && $request->hasFile($row->name)) {
                    $file = $request->file($row->name);
                    if ($file->isValid()) {
                        $filename = date('Ymd-hsi').random_int(0, 999999).$file->getClientOriginalName();
                        $file->move(public_path().'/media/FormUpload/', $filename);
                        $uploaded_files[$row->name][] = env('APP_URL').'/media/FormUpload/'.$filename;
                    }
                }
            }
            if (\count($uploaded_files) > 0) {
                return $uploaded_files;
            }
        }

        return null;
    }

    /**
     * Логирование отправленных данных в БД FormsLog.
     *
     * @param LarrockForm $form
     * @param Request $request
     * @param null|array $uploaded_files
     */
    public function formLog(LarrockForm $form, Request $request, $uploaded_files = null)
    {
        if ($form->formLog) {
            $data = array_filter($request->except($form->exceptRender), function ($value) {
                if ($value !== null && ! empty($value)) {
                    return $value;
                }

                return null;
            });

            $formsLog = new FormsLog();
            $formsLog['title'] = $form->title;
            $formsLog['form_data'] = $data;
            $formsLog['form_name'] = $form->name;
            if ($uploaded_files && \is_array($uploaded_files)) {
                $formsLog['form_files'] = $uploaded_files;
            }
            $formsLog->save();
        }
    }

    /**
     * Отправка письма.
     *
     * @param LarrockForm $form
     * @param Request $request
     * @param null|array $uploaded_files
     * @return bool
     * @throws \Exception
     */
    public function mail(LarrockForm $form, Request $request, $uploaded_files)
    {
        if (env('MAIL_STOP') !== true) {
            $mails = array_map('trim', explode(',', env('MAIL_TO_ADMIN')));
            if ($request->has('email') && ! empty($request->get('email'))) {
                $mails[] = $request->get('email');
            }
            $mails = array_unique($mails);

            /* @noinspection PhpVoidFunctionResultUsedInspection */
            $test = Mail::send($form->mailTemplate, [
                'data' => $request->except($form->exceptRender),
                'form' => $form,
                'uploaded_files' => $uploaded_files,
            ], function ($message) use ($mails, $form) {
                $message->from($form->mailFromAddress);
                $message->to($mails);
                $message->subject($form->mailSubject);
            });
            MessageLarrock::success($form->messageSuccess);
        } else {
            MessageLarrock::danger('Отправка писем отключена опцией MAIL_STOP', true);
        }

        return true;
    }

    /**
     * Отрисовка тела шаблона письма вместо его отправки. Для дебага.
     *
     * @param LarrockForm $form
     * @param null|array $data
     * @param null|array $uploaded_files
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function debugMail($form, $data, $uploaded_files = null)
    {
        return view($form->mailTemplate, [
            'data' => $data,
            'form' => $form,
            'uploaded_files' => $uploaded_files,
        ]);
    }

    /**
     * Получение списка полей, которые не следует передавать в шаблон письма.
     *
     * @param $form
     * @return array
     */
    public function exceptMailData($form)
    {
        $except_mail_data = array_get($form['email'], 'dataExcept');
        $except_service_data = ['g-recaptcha-response', '_token', 'form_id'];
        foreach ($form->rows as $row) {
            if ($row instanceof FormButton || $row instanceof FormFile) {
                $except_service_data[] = $row->name;
            }
        }

        return array_merge($except_mail_data, $except_service_data);
    }
}
