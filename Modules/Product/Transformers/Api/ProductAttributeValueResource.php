<?php

namespace Modules\Product\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributeValueResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'title'               => $this->value->translate(locale())->title,
           'attribute_value_id'  => $this->attribute_value_id,
           'price'               => $this->value->price,
       ];
    }
}
