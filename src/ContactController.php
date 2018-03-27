<?php

namespace Larrock\ComponentContact;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Larrock\ComponentContact\Facades\LarrockContact;
use Larrock\ComponentContact\Helpers\LarrockForm;
use Larrock\ComponentContact\Models\FormsLog;
use Larrock\Core\Helpers\MessageLarrock;
use Validator;
use Mail;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware(LarrockContact::combineFrontMiddlewares());
    }

    /**
     * Экшен отправки форм
     *
     * @param Request $request
     * @param $formName
     * @return \Illuminate\Http\RedirectResponse|string
     * @throws \Exception
     * @throws \Throwable
     */
    public function sendForm(Request $request, $formName)
    {
        $larrockContact = LarrockContact::shareConfig();

        /** @var LarrockForm $form */
        $form = $larrockContact->getForm($formName);

        $this->validateForm($form, $request);

        if($form->debugMail){
            return $form->renderMail($request->except($form->exceptRender));
        }

        if( !$form->mailFromAddress){
            throw new \Exception('mailFromAddress не определен', 422);
        }

        //$uploaded_file = $this->uploadFile($form, $request);
        $uploaded_file = null;
        $this->formLog($form, $request);
        $this->mail($form, $request, $uploaded_file);

        if($form->redirect){
            return redirect()->to($form->redirect);
        }
        return back();
    }


    /**
     * Валидация данных формы
     *
     * @param LarrockForm $form
     * @param Request $request
     * @return $this|bool
     */
    public function validateForm($form, Request $request)
    {
        if($form->valid){
            $validator = Validator::make($request->all(), $form->valid);
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
     * @param LarrockForm $form
     * @param Request $request
     * @return null|string
     * @throws \Symfony\Component\HttpFoundation\File\Exception\FileException
     */
    protected function uploadFile(LarrockForm $form, Request $request)
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
     * @param LarrockForm $form
     * @param Request $request
     */
    protected function formLog(LarrockForm $form, Request $request)
    {
        if($form->formLog){
            $formsLog = new FormsLog();
            $formsLog['title'] = $form->title;
            $formsLog['form_data'] = $request->all();
            $formsLog['form_name'] = $form->name;
            $formsLog->save();
        }
    }


    /**
     * Отправка письма
     *
     * @param LarrockForm $form
     * @param Request $request
     * @param $uploaded_file
     * @return bool
     * @throws \Exception
     */
    public function mail(LarrockForm $form, Request $request, $uploaded_file)
    {
        if(env('MAIL_STOP') !== TRUE){
            $mails = array_map('trim', explode(',', $form->mailFromAddress));
            if($request->has('email') && !empty($request->get('email'))){
                $mails[] = $request->get('email');
            }
            $mails = array_unique($mails);

            /** @noinspection PhpVoidFunctionResultUsedInspection */
            Mail::send($form->mailTemplate, [
                    'data' => $request->except($form->exceptRender),
                    'form' => $form,
                    'uploaded_file' => $uploaded_file
                ], function($message) use ($mails, $form){
                    $message->from($form->mailFromAddress);
                    $message->to($mails);
                    $message->subject($form->mailSubject);
                });
            MessageLarrock::success($form->messageSuccess);
        }else{
            MessageLarrock::danger('Отправка писем отключена опцией MAIL_STOP', TRUE);
        }
        return TRUE;
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
        return view($form->template, [
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