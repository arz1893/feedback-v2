<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SuggestionProduct extends Resource
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
            'customer_suggestion' => $this->customer_suggestion,
            'customer' => $this->customer,
            'product' => new Product($this->product),
            'productCategory' => $this->product_category,
            'tenantId' => $this->tenantId,
            'attachment' => ($this->attachment == null ? null:asset($this->attachment)),
            'created_by' => $this->created_by->name,
            'created_at' => $this->created_at->format('d F Y, H:iA'),
            'edit_url' => route('suggestion_product_list.edit', $this->systemId)
        ];
    }
}
