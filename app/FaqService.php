<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqService extends Model
{
    protected $table = 'faq_services';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'question',
        'answer',
        'serviceId',
        'systemcreator',
        'syslastupdater',
        'sysdeleted'
    ];

    public function service() {
        return $this->belongsTo(Service::class, 'serviceId', 'systemId');
    }
}
