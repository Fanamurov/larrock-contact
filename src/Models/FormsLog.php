<?php

namespace Larrock\ComponentContact\Models;

use Illuminate\Database\Eloquent\Model;

class FormsLog extends Model
{
    protected $searchable = [
        'columns' => [
            'forms_log.form_name' => 10,
            'forms_log.form_data' => 10,
        ]
    ];

    protected $table = 'forms_log';

    protected $fillable = ['from_id', 'form_name', 'form_data', 'form_status'];

    protected $casts = [
        'form_id' => 'integer'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function setFormDataAttribute($value)
    {
        $this->attributes['form_data'] = json_encode($value);
    }

    public function getFormDataAttribute($value){
        return json_decode($value);
    }
}
