<?php

namespace Larrock\ComponentContact;

use Cache;
use Illuminate\Support\Collection;
use Larrock\ComponentContact\Facades\LarrockContact;
use Larrock\ComponentContact\Helpers\LarrockForm;
use Larrock\ComponentContact\Models\FormsLog;
use Larrock\Core\Component;
use Larrock\Core\Helpers\FormBuilder\FormButton;
use Larrock\Core\Helpers\FormBuilder\FormCheckbox;
use Larrock\Core\Helpers\FormBuilder\FormDate;
use Larrock\Core\Helpers\FormBuilder\FormInput;
use Larrock\Core\Helpers\FormBuilder\FormSelect;

class ContactComponent extends Component
{
    /** @var Collection|null */
    public $forms;

    public function __construct()
    {
        $this->name = 'contact';
        $this->table = 'forms_log';
        $this->title = 'Формы';
        $this->description = 'Формы для сайта';
        $this->model = \config('larrock.models.contact', FormsLog::class);
        $this->addRows()->isSearchable();
        $this->forms = collect();
        $this->createForms();
    }

    protected function addRows()
    {
        $row = new FormInput('title', 'Название формы');
        $this->setRow($row);

        $row = new FormSelect('form_status', 'Статус формы');
        $this->setRow($row->setValid('max:255')->setAllowCreate()
            ->setOptions(['Новая', 'Обработано', 'Завершено'])
            ->setInTableAdminEditable()->setCssClassGroup('uk-width-1-1 uk-width-1-3@m'));

        $row = new FormDate('created_at', 'Дата получения');
        $this->setRow($row->setInTableAdmin()->setCssClassGroup('uk-width-1-1 uk-width-1-3@m'));

        $row = new FormDate('updated_at', 'Дата обработки');
        $this->setRow($row->setInTableAdmin()->setCssClassGroup('uk-width-1-1 uk-width-1-3@m'));

        return $this;
    }

    protected function createForms()
    {
        $form = new LarrockForm('minimal', 'Оставьте свой номер телефона');
        $row = new FormInput('tel', 'Телефон');
        $form->setRow($row->setValid('required'));
        $row = new FormButton('send', 'Отправить');
        $form->setRow($row);

        $this->forms->push($form);

        $form = new LarrockForm('backphone', 'Обратный звонок');
        $row = new FormInput('tel', 'Телефон');
        $form->setRow($row->setValid('required_without:email'));
        $row = new FormInput('email', 'Email');
        $form->setRow($row->setValid('required_without:tel'));
        $row = new FormCheckbox('agree', 'Я согласен на обработку персональных данных');
        $form->setRow($row->setValid('required'));
        $form->setRow(new FormButton('send', 'Отправить'));
        $form->setExceptRender(['agree']);

        $this->forms->push($form);

        return $this;
    }

    public function getForms()
    {
        return $this->forms;
    }

    public function getForm($formName)
    {
        return $this->forms->firstWhere('name', $formName);
    }

    public function renderAdminMenu()
    {
        $count = Cache::rememberForever('count-data-admin-'. LarrockContact::getName(), function(){
            return LarrockContact::getModel()->count(['id']);
        });
        $count_new = Cache::rememberForever('count-new-data-admin-'. LarrockContact::getName(), function(){
            return LarrockContact::getModel()->whereFormStatus('Новая')->count(['id']);
        });
        return view('larrock::admin.sectionmenu.types.default', ['count' => $count .'/'. $count_new,
            'app' => LarrockContact::getConfig(), 'url' => '/admin/'. LarrockContact::getName()]);
    }

    public function toDashboard()
    {
        $data = Cache::rememberForever('LarrockContactItemsDashboard', function(){
            return LarrockContact::getModel()->latest('updated_at')->take(5)->get();
        });
        return view('larrock::admin.dashboard.formslog', ['component' => LarrockContact::getConfig(), 'data' => $data]);
    }
}