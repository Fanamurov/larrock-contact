<?php

namespace Larrock\ComponentContact;

use Breadcrumbs;
use Illuminate\Routing\Controller;
use Larrock\ComponentContact\Facades\LarrockContact;
use Larrock\Core\Traits\AdminMethodsDestroy;
use Larrock\Core\Traits\AdminMethodsIndex;

class AdminContactController extends Controller
{
    use AdminMethodsIndex, AdminMethodsDestroy;

    public function __construct()
    {
        $this->config = LarrockContact::shareConfig();
        \Config::set('breadcrumbs.view', 'larrock::admin.breadcrumb.breadcrumb');

        Breadcrumbs::register('admin.'. LarrockContact::getName() .'.index', function($breadcrumbs){
            $breadcrumbs->push(LarrockContact::getTitle(), '/admin/'. LarrockContact::getName());
        });
    }

    public function edit($id)
    {
        $data['data'] = $this->config->getModel()::findOrFail($id);
        $data['app'] = $this->config->tabbable($data['data']);

        $template = 'larrock::emails.formDefault';
        if($form_name = $data['data']->form_name){
            $template = config('larrock-form.'. $form_name .'.emailTemplate', 'larrock::emails.formDefault');
        }

        $data['emailData'] = view($template, ['data' => $data['data']->form_data])->render();

        Breadcrumbs::register('admin.'. LarrockContact::getName() .'.edit', function($breadcrumbs, $data)
        {
            $breadcrumbs->parent('admin.'. LarrockContact::getName() .'.index');
            $breadcrumbs->push($data->title);
        });

        return view('larrock::admin.contact.edit', $data);
    }
}