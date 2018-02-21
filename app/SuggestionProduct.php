<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuggestionProduct extends Model
{
    protected $table = 'suggestion_products';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'customer_rating',
        'customer_suggestion',
        'customerId',
        'productId',
        'productCategoryId',
        'tenantId',
        'attachment',
        'syscreator'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customerId', 'systemId');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'productId', 'systemId');
    }

    public function product_category() {
        return $this->belongsTo(ProductCategory::class, 'productCategoryId', 'id');
    }

    public function created_by() {
        return $this->belongsTo(User::class, 'syscreator', 'systemId');
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenantId', 'systemId');
    }
}
