<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ComplaintService extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'systemId' => $this->systemId,
            'customer_rating' => $this->customer_rating,
            'customer_complaint' => $this->customer_complaint,
            'is_need_call' => $this->is_need_call,
            'is_urgent' => $this->is_urgent,
            'customer' => $this->customer,
            'service' => new Service($this->service),
            'service_category' => $this->service_category,
            'complaint_replies' => ($this->complaint_service_replies == null ? null:$this->complaint_service_replies),
            'tenant_id' => $this->tenantId,
            'attachment' => ($this->attachment == null ? null:asset($this->attachment)),
            'created_by' => $this->created_by->name,
            'created_at' => $this->created_at->format('d F Y, H:iA')
        ];
    }
}
