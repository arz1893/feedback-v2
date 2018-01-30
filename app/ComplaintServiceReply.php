<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintServiceReply extends Model
{
    protected $table = 'complaint_service_replies';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'reply_content',
        'parentId',
        'customerId',
        'attachment',
        'complaintServiceId',
        'syscreator',
        'sysupdater'
    ];

    public function parent() {
        return $this->belongsTo(ComplaintServiceReply::class, 'parentId', 'systemId');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customerId', 'systemId');
    }

    public function complaint_service() {
        return $this->belongsTo(ComplaintService::class, 'complaintServiceId', 'systemId');
    }

    public function created_by() {
        return $this->belongsTo(User::class, 'syscreator', 'systemId');
    }
}
