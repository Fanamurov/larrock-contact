<?php

namespace Larrock\ComponentContact\Models;

use Illuminate\Database\Eloquent\Model;
use Larrock\Core\Traits\GetLink;

class FormsLog extends Model
{
    use GetLink;
    
    protected $searchable = [
        'columns' => [
            'forms_log.title' => 15,
            'forms_log.form_data' => 10,
        ]
    ];

    protected $table = 'forms_log';

    protected $fillable = ['form_name', 'title', 'form_data', 'form_status'];

    protected $dates = ['created_at', 'updated_at'];

    public function setFormDataAttribute($value)
    {
        $this->attributes['form_data'] = json_encode($value);
    }

    public function getFormDataAttribute($value){
        return json_decode($value);
    }
}
