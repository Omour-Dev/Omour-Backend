<?php

namespace Modules\Product\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'price'                => $this->price,
            'qty'                  => $this->qty,
            'image'                => url($this->image),
            'title'                => $this->translate(locale())->title,
            'description'          => htmlView($this->translate(locale())->description),
            'short_description'    => $this->translate(locale())->short_description,
            'new_arrival'          => new ProductNewArrivalResource($this->whenLoaded('arrival')),
            'offer'                => new ProductOfferResource($this->whenLoaded('offer')),
            'images'               => ProductImagesResource::collection($this->whenLoaded('images')),
            'products_options'     => ProductOptionResource::collection($this->whenLoaded('productOptions')),
            'products_attributes'  => ProductAttributeResource::collection($this->whenLoaded('productAttributes')),
        ];
    }
}
