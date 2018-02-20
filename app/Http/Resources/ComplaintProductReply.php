<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ComplaintProductReply extends Resource
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
            'reply_content' => $this->reply_content,
            'created_by' => new User($this->created_by)
        ];
    }
}
