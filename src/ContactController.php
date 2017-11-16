<?php

namespace Larrock\ComponentContact;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Larrock\ComponentContact\Models\FormsLog;
use Session;
use Validator;
use Mail;

class ContactController extends Controller
{
    public function send_form(Request $request)
    {
        if($form = config('larrock-form.'. $request->get('form_id'))){
            if( !isset($form['email'])){
                $form['email']['to'] = env('MAIL_TO_ADMIN');
                $form['email']['dataExcept'] = [];
            }
            $this->validateForm($form, $request);
            if(array_get($form, 'debugMail', FALSE) === TRUE){
                return $this->debugMail($form, $request);
            }
            $uploaded_file = $this->uploadFile($form, $request);
            $this->formLog($form, $request);
            $this->mail($form, $request, $uploaded_file);
        }else{
            Session::push('message.danger', 'Конфигурация формы не найдена');
        }

        if(array_has($form,'redirect')){
            return redirect($form['redirect']);
        }
        return back();
    }


    /**
     * Создание JSValidation formRequest
     *
     * @param $form
     * @param Request $request
     * @return $this|bool
     */
    public function validateForm($form, Request $request)
    {
        if(array_has($form, 'rules')){
            $validator = Validator::make($request->all(), $form['rules']);
            if($validator->fails()){
                return back()->withInput($request->except('password'))->withErrors($validator);
            }
        }
        return TRUE;
    }


    /**
     * Загрузка файла из формы
     *
     * TODO: Добавить проверку нужна ли вообще загрузка,
     * TODO: проверка загружаемого файла по расширениям
     * TODO: помещение в папку недоступную для открытия с фронта (security)
     * @param $form
     * @param Request $request
     * @return null|string
     */
    protected function uploadFile($form, Request $request)
    {
        if($request->hasFile('file')) {
            $file = $request->file('file');
            if($file->isValid()){
                $filename = date('Ymd-hsi'). $file->getClientOriginalName();
                $file->move(public_path() .'/media/FormUpload/', $filename);
                return env('APP_URL') .'/media/FormUpload/'. $filename;
            }
        }
        return NULL;
    }


    /**
     * Логирование отправленных данных в БД FormsLog
     *
     * @param $form
     * @param Request $request
     */
    protected function formLog($form, Request $request)
    {
        if(config('larrock-form.forms_log', TRUE) === TRUE && array_get($form, 'forms_log', 'TRUE') === TRUE){
            $formsLog = new FormsLog();
            $formsLog['title'] = array_get($form, 'name', 'Форма');
            $formsLog['form_data'] = $request->except($this->exceptMailData($form));
            $formsLog->save();
        }
    }


    /**
     * Отправка письма
     *
     * @param $form
     * @param Request $request
     * @param $uploaded_file
     */
    public function mail($form, Request $request, $uploaded_file)
    {
        if(env('MAIL_STOP') !== TRUE){
            $to = env('MAIL_TO_ADMIN');
            if(isset($form['email']['to'])){
                $to = $form['email']['to'];
            }
            $mails = array_map('trim', explode(',', $to));
            if($request->has('email') && !empty($request->get('email'))){
                $mails[] = $request->get('email');
            }
            $admin_mails = explode(',', env('MAIL_TO_ADMIN', 'robot@martds.ru'));
            $mails = array_merge($admin_mails, $mails);
            $mails = array_unique($mails);

            /** @noinspection PhpVoidFunctionResultUsedInspection */
            Mail::send(
                array_get($form['email'], 'template', 'larrock::emails.formDefault'),
                [
                    'data' => $request->except($this->exceptMailData($form)),
                    'form' => $form,
                    'uploaded_file' => $uploaded_file
                ],
                function($message) use ($mails, $form){
                    $message->from(array_get($form['email'], 'from', env('MAIL_FROM_ADDRESS')));
                    $message->to($mails);
                    $message->subject(array_get($form['email'], 'subject', 'Отправлена форма '. env('APP_URL')));
                });
            Session::push('message.success', array_get($form['email'], 'successMessage', 'Форма отправлена. '. env('SITE_NAME', env('APP_URL'))));
        }else{
            Session::push('message.danger', 'Отправка писем отключена опцией MAIL_STOP');
        }
    }


    /**
     * Отрисовка тела шаблона письма вместо его отправки. Для дебага
     *
     * @param $form
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function debugMail($form, Request $request)
    {
        return view(array_get($form['email'], 'template', 'larrock::emails.formDefault'),
            [
                'data' => $request->except($this->exceptMailData($form)),
                'form' => $form,
                'uploaded_file' => 'Загрузка файла в дебаге отключена'
            ]);
    }


    /**
     * Получение списка полей, которые не следует передавать в шаблон письма
     *
     * @param $form
     * @return array
     */
    protected function exceptMailData($form)
    {
        $except_mail_data = array_get($form['email'], 'dataExcept');
        $except_service_data = ['g-recaptcha-response', '_token', 'form_id', 'file'];
        return array_merge($except_mail_data, $except_service_data);
    }
}