<?php

namespace Modules\Product\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'title'            => $this->attribute->translate(locale())->title,
           'value_id'         => $this->attribute_id,
           'attribute_values' => ProductAttributeValueResource::collection($this->productAttributeValues),
       ];
    }
}
