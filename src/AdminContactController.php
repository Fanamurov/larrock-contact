<?php

namespace Larrock\ComponentContact;

use Illuminate\Routing\Controller;
use Larrock\ComponentContact\Facades\LarrockContact;
use Larrock\Core\Traits\AdminMethodsDestroy;
use Larrock\Core\Traits\AdminMethodsIndex;
use Larrock\Core\Traits\ShareMethods;

class AdminContactController extends Controller
{
    use AdminMethodsIndex, AdminMethodsDestroy, ShareMethods;

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

        $data['emailData'] = view($template, ['data' => $data['data']->form_data])->render();
        return view('larrock::admin.contact.edit', $data);
    }
}