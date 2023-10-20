<?php

namespace Modules\Coupon\Repositories\Api;

use Modules\Coupon\Entities\Coupon;

class CouponRepository
{
    function __construct(Coupon $coupon)
    {
        $this->coupon   = $coupon;
    }

    public function checkCoupon($request)
    {
        $coupon = $this->coupon->where('status',1)
                               ->where('code', $request['code'])
                               ->where('start','<=',date('Y-m-d'))
                               ->where('end','>=',date('Y-m-d'))
                               ->first();
        return $coupon;
    }
}
