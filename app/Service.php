<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'name',
        'description',
        'status',
        'img',
        'tenantId',
        'syscreator',
        'syslastupdater',
        'sysdeleted'
    ];

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenantId');
    }

    public function service_categories() {
        return $this->hasMany(ServiceCategory::class);
    }

    public function faq_services() {
        return $this->hasMany(FaqService::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'service_tag', 'serviceId', 'tagId')->withTimestamps();
    }
}
