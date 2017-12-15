<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqProduct extends Model
{
    protected $table = 'faq_products';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'question',
        'answer',
        'productId',
        'syscreator',
        'syslastupdater',
        'sysdeleted'
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'productId', 'systemId');
    }
}
