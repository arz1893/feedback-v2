<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Product extends Resource
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
            'img' => ($this->img == null ? asset('default-images/no-image.jpg'):asset($this->img)),
            'productTags' => $this->tags,
            'show_faq_url' => route('faq_product.show', $this->systemId),
            'show_complaint_url' => route('show_complaint_product', [$this->systemId, 0]),
            'show_suggestion_url' => route('show_suggestion_product', [$this->systemId, 0])
        ];
    }
}
