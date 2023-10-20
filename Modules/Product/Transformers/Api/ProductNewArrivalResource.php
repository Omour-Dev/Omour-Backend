<?php

namespace Modules\Product\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductNewArrivalResource extends JsonResource
{
    public function toArray($request)
    {
        return [
          'status'  => true
       ];
    }
}
