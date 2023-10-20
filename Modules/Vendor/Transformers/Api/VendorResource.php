<?php

namespace Modules\Vendor\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Worker\Transformers\Api\WorkerResource;

class VendorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'  => $this->id,
            'rate'          => number_format($this->rates->avg('vendor_rate'), 1),
            'image'         => url($this->image),
            'delivery_time' => $this->delivery_time,
            'title'         => $this->translate(locale())->title,
            'opening'       => $this->openingStatus->translate(locale())->title,
            'description'   => htmlView($this->translate(locale())->description),
            'images'        => VendorImagesResource::collection($this->whenLoaded('images')),
        ];
    }
}
