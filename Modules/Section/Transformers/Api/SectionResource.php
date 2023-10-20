<?php

namespace Modules\Section\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Vendor\Transformers\Api\VendorResource;

class SectionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'  => $this->id,
            'title'         => $this->translate(locale())->title,
            'image'         => url($this->image),
        ];
    }
}
