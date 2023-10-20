<?php

namespace Modules\Attribute\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeValueResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'title' => $this->translate(locale())->title,
            'price' => $this->price,
       ];
    }
}
