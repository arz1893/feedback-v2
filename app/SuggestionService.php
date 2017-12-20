<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuggestionService extends Model
{
    protected $table = 'suggestion_services';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'customer_rating',
        'customer_suggestion',
        'customerId',
        'serviceId',
        'serviceCategoryId',
        'tenantId'
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
