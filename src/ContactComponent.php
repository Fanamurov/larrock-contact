<?php

namespace Larrock\ComponentContact;

use Larrock\ComponentContact\Facades\LarrockContact;
use Larrock\ComponentContact\Models\FormsLog;
use Larrock\Core\Component;
use Larrock\Core\Helpers\FormBuilder\FormDate;
use Larrock\Core\Helpers\FormBuilder\FormInput;
use Larrock\Core\Helpers\FormBuilder\FormSelect;

class ContactComponent extends Component
{
    public function __construct()
    {
        $this->name = 'contact';
        $this->table = 'forms_log';
        $this->title = 'Формы';
        $this->description = 'Формы для сайта';
        $this->model = \config('larrock.models.contact', FormsLog::class);
        $this->addRows()->isSearchable();
    }

    protected function addRows()
    {
        $row = new FormInput('title', 'Название формы');
        $this->rows['title'] = $row;

        $row = new FormSelect('form_status', 'Статус формы');
        $this->rows['form_status'] = $row->setValid('max:255')->setAllowCreate()
            ->setOptions(['Новая', 'Обработано', 'Завершено'])
            ->setInTableAdminAjaxEditable()->setCssClassGroup('uk-width-1-1 uk-width-medium-1-3');

        $row = new FormDate('created_at', 'Дата получения');
        $this->rows['created_at'] = $row->setInTableAdmin()->setCssClassGroup('uk-width-1-1 uk-width-medium-1-3');

        $row = new FormDate('updated_at', 'Дата обработки');
        $this->rows['updated_at'] = $row->setInTableAdmin()->setCssClassGroup('uk-width-1-1 uk-width-medium-1-3');

        return $this;
    }

    public function renderAdminMenu()
    {
        $count = \Cache::remember('count-data-admin-'. LarrockContact::getName(), 1440, function(){
            return LarrockContact::getModel()->count(['id']);
        });
        $count_new = \Cache::remember('count-new-data-admin-'. LarrockContact::getName(), 1440, function(){
            return LarrockContact::getModel()->whereFormStatus('Новая')->count(['id']);
        });
        return view('larrock::admin.sectionmenu.types.default', ['count' => $count .'/'. $count_new, 'app' => LarrockContact::getConfig(), 'url' => '/admin/'. LarrockContact::getName()]);
    }

    public function toDashboard()
    {
        $data = \Cache::remember('LarrockContactItems', 1440, function(){
            return LarrockContact::getModel()->get();
        });
        return view('larrock::admin.dashboard.formslog', ['component' => LarrockContact::getConfig(), 'data' => $data]);
    }
}