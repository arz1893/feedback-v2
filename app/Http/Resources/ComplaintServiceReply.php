<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ComplaintServiceReply extends Resource
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
            'created_by' => new User($this->created_by),
            'created_at' => $this->created_at->format('d F Y H:iA'),
            'is_already_called' => false
        ];
    }
}
