<?php

namespace Modules\Order\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Product\Transformers\Api\ProductResource;

class OrderProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'price'              => $this->price,
            'qty'                => $this->qty,
            'total'              => $this->total,
            'title'              => new ProductResource($this->product),
            'options'            => OrderProductOptionResource::collection($this->orderProductOptions),
            'attributes'         => OrderProductAttributeResource::collection($this->orderProductAttributes)
        ];
    }
}
