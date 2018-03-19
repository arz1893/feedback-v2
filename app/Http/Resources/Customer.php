<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Customer extends Resource
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
            'address' => $this->address,
            'phone' => $this->phone,
            'city' => $this->city,
            'email' => $this->email,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate,
            'memo' => $this->memo,
            'tenantId' => $this->tenantId,
            'created_at' => $this->created_at
        ];
    }
}
