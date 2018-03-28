<?php

namespace Larrock\ComponentContact;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Larrock\ComponentContact\Facades\LarrockContact;
use Larrock\ComponentContact\Helpers\FormSend;
use Larrock\ComponentContact\Helpers\LarrockForm;

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
        $formSend = new FormSend();
        $larrockContact = LarrockContact::shareConfig();

        /** @var LarrockForm $form */
        $form = $larrockContact->getForm($formName);

        $valid = $formSend->validateForm($form, $request);
        if($valid !== TRUE){
            return back()->withInput($request->except('password'))->withErrors($valid);
        }

        if( !$form->mailFromAddress){
            throw new \Exception('mailFromAddress не определен', 422);
        }

        $uploaded_files = $formSend->uploadFile($form, $request);
        if($form->debugMail){
            return $formSend->debugMail($form, $request->except($form->exceptRender), $uploaded_files);
        }
        $formSend->formLog($form, $request, $uploaded_files);
        $formSend->mail($form, $request, $uploaded_files);

        if($form->redirect){
            return redirect()->to($form->redirect);
        }
        return back();
    }
}