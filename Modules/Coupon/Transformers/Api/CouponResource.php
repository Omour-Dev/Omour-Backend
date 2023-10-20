<?php

namespace Modules\Coupon\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Vendor\Transformers\Api\VendorResource;

class CouponResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'  => $this->id,
            'code'          => $this->code,
            'fixed'         => (float) $this->fixed,
            'percentage'    => (float) $this->percentage,
        ];
    }
}
