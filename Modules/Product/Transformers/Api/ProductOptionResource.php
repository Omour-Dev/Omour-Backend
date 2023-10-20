<?php

namespace Modules\Product\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductOptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'title'            => $this->option->translate(locale())->title,
           'option_id'        => $this->option_id,
           'option_values'    => ProductOptionValueResource::collection($this->productOptionValues),
       ];
    }
}
