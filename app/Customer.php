<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'name',
        'address',
        'city',
        'email',
        'gender',
        'phone',
        'birthdate',
        'memo',
        'tenantId'
    ];

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenantId', 'systemId');
    }

    public function getFullInformationAttribute() {
        return "{$this->name} - {$this->phone}";
    }
}
