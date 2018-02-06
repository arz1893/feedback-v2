<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'name',
        'defValue',
        'bgColor',
        'recOwner',
        'syscreator',
        'syslastupdater',
        'sysdeleted',
    ];

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'recOwner', 'systemId');
    }

    public function created_by() {
        return $this->belongsTo(User::class, 'syscreator', 'systemId');
    }

    public function updated_by() {
        return $this->belongsTo(User::class, 'syslastupdater', 'systemId');
    }
}
