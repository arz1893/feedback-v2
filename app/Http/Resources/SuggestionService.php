<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SuggestionService extends Resource
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
            'service' => new Service($this->service),
            'serviceCategory' => $this->service_category,
            'tenantId' => $this->tenantId,
            'attachment' => ($this->attachment == null ? null:asset($this->attachment)),
            'created_by' => $this->created_by->name,
            'created_at' => $this->created_at->format('d F Y, H:iA')
        ];
    }
}
