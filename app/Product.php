<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'name',
        'metric',
        'price',
        'hasstock',
        'stockMin',
        'hasdiscount',
        'discValue',
        'discType',
        'status',
        'img',
        'barcode',
        'description',
        'tenantId',
        'syscreator',
        'syslastupdater',
        'sysdeleted'
    ];

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenantId', 'systemId');
    }

    public function product_categories() {
        return $this->hasMany(ProductCategory::class);
    }

    public function faq_products() {
        return $this->hasMany(FaqProduct::class);
    }

    public function complaint_products() {
        return $this->hasMany(ComplaintProduct::class);
    }

    public function suggestion_products() {
        return $this->hasMany(SuggestionProduct::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'product_tag', 'productId', 'tagId')->withTimestamps();
    }

    public function filterByTags($tagIds) {
        return $this->belongsToMany(Tag::class, 'product_tag', 'productId', 'tagId')->wherePivotIn('tagId', $tagIds);
    }
}
