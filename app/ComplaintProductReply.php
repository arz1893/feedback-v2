<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintProductReply extends Model
{
    protected $table = 'complaint_product_replies';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'reply_content',
        'parentId',
        'customerId',
        'attachment',
        'complaintProductId',
        'syscreator',
        'sysupdater'
    ];

    public function parent() {
        return $this->belongsTo(ComplaintProductReply::class, 'parentId', 'systemId');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customerId', 'systemId');
    }

    public function complaint_product() {
        return $this->belongsTo(ComplaintProduct::class, 'complaintProductId', 'systemId');
    }

    public function created_by() {
        return $this->belongsTo(User::class, 'syscreator', 'systemId');
    }
}
