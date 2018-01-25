<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintService extends Model
{
    protected $table = 'complaint_services';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'customer_rating',
        'customer_complaint',
        'is_need_call',
        'is_urgent',
        'customerId',
        'serviceId',
        'serviceCategoryId',
        'tenantId',
        'attachment',
        'is_answered'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customerId', 'systemId');
    }

    public function service() {
        return $this->belongsTo(Service::class, 'serviceId', 'systemId');
    }

    public function service_category() {
        return $this->belongsTo(ServiceCategory::class, 'serviceCategoryId', 'id');
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenantId', 'systemId');
    }
}
