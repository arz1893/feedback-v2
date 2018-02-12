<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Service extends Resource
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
            'name' => $this->name,
            'img' => $this->img,
            'serviceTags' => $this->tags,
            'show_url' => route('show_complaint_service', [$this->systemId, 0])
        ];
    }
}
