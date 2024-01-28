<?php

namespace Modules\Vendor\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorAreaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'vendor_id'       => $this->vendor_id,
            'area_id'         => $this->area_id,
            'shipping_price'  => $this->shipping_price,
        ];
    }
}
