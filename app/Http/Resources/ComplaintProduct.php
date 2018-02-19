<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ComplaintProduct extends Resource
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
            'product' => $this->product,
            'product_category' => $this->product_category,
            'tenant_id' => $this->tenantId,
            'attachment' => $this->attachment
        ];
    }
}
