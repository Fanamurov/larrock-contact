<?php

namespace Larrock\ComponentContact;

use Illuminate\Routing\Controller;
use Larrock\Core\Traits\ShareMethods;
use Larrock\Core\Traits\AdminMethodsDestroy;
use Larrock\ComponentContact\Helpers\LarrockForm;
use Larrock\ComponentContact\Facades\LarrockContact;

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

        $template = 'larrock::emails.formDefault';
        if ($form_name = $data['data']->form_name) {
            $template = LarrockContact::getForm($form_name)->mailTemplate;
        }

        /** @var LarrockForm $form */
        $form = $this->config->getForm($data['data']->form_name);
        $formData = collect($data['data']->form_data);

        $data['emailData'] = view($template, ['data' => $formData->except($form->exceptRender), 'form' => $form, 'uploaded_files' => $data['data']->form_files])->render();

        return view('larrock::admin.contact.edit', $data);
    }
}
