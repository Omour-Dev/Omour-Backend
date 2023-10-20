<?php

namespace Modules\Product\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductOptionValueResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'title'            => $this->value->translate(locale())->title,
           'option_value_id'  => $this->option_value_id,
       ];
    }
}
