<?php

namespace Modules\Offer\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Vendor\Transformers\Api\VendorResource;

class OfferResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'  => $this->id,
            'image'         => url($this->image),
            'title'         => $this->translate(locale())->title,
            'description'   => htmlView($this->translate(locale())->description),
            'vendors'       => VendorResource::collection($this->vendors),
        ];
    }
}
