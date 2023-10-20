<?php

namespace Modules\Vendor\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorImagesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'     => $this->id,
           'image'  => url($this->image),
       ];
    }
}
