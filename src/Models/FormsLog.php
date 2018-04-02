<?php

namespace Larrock\ComponentContact\Models;

use Larrock\Core\Traits\GetLink;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FormsLog.
 * @property int $id
 * @property int $form_id
 * @property string $title
 * @property array $form_data
 * @property string $form_name
 * @property array $form_files
 * @property string $form_status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class FormsLog extends Model
{
    use GetLink;

    protected $searchable = [
        'columns' => [
            'forms_log.title' => 15,
            'forms_log.form_data' => 10,
        ],
    ];

    protected $table = 'forms_log';

    protected $fillable = ['form_id', 'title', 'form_name', 'form_data', 'form_files', 'form_status'];

    protected $dates = ['created_at', 'updated_at'];

    public function setFormDataAttribute($value)
    {
        $this->attributes['form_data'] = json_encode($value);
    }

    public function getFormDataAttribute($value)
    {
        return json_decode($value);
    }

    public function setFormFilesAttribute($value)
    {
        $this->attributes['form_files'] = json_encode($value);
    }

    public function getFormFilesAttribute($value)
    {
        return json_decode($value);
    }
}
