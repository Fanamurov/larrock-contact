<?php

namespace Larrock\ComponentContact;

use Illuminate\Routing\Controller;
use Larrock\ComponentContact\Facades\LarrockContact;
use Larrock\ComponentContact\Helpers\LarrockForm;
use Larrock\Core\Traits\AdminMethodsDestroy;
use Larrock\Core\Traits\ShareMethods;

class AdminContactController extends Controller
{
    use AdminMethodsDestroy, ShareMethods;

    /**
     * AdminContactController constructor.
     */
    public function __construct()
    {
        $this->shareMethods();
        $this->middleware(LarrockContact::combineAdminMiddlewares());
        $this->config = LarrockContact::shareConfig();
        \Config::set('breadcrumbs.view', 'larrock::admin.breadcrumb.breadcrumb');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \View
     */
    public function index()
    {
        //Получаем созданные формы
        $data['forms'] = LarrockContact::getForms();

        $data['data'] = $this->config->getModel()::orderBy('created_at', 'DESC')->paginate(30);
        return view('larrock::admin.contact.index', $data);
    }

    /**
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function edit($id)
    {
        $data['data'] = $this->config->getModel()::findOrFail($id);
        $data['app'] = $this->config->tabbable($data['data']);

        $template = 'larrock::emails.formDefault';
        if($form_name = $data['data']->form_name){
            $template = config('larrock-form.'. $form_name .'.emailTemplate', 'larrock::emails.formDefault');
        }

        /** @var LarrockForm $form */
        $form = $this->config->getForm($data['data']->form_name);

        $formData = collect($data['data']->form_data);

        $data['emailData'] = view($template, ['data' => $formData->except($form->exceptRender), 'form' => $form])->render();
        return view('larrock::admin.contact.edit', $data);
    }
}