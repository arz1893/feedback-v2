<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Question extends Model
{
    protected $table = 'questions';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'customerId',
        'question',
        'answer',
        'is_need_call',
        'tenantId'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customerId', 'systemId');
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenantId', 'systemId');
    }
}
