<?php

namespace Modules\Coupon\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Coupon\Transformers\Api\CouponResource;
use Modules\Coupon\Repositories\Api\CouponRepository as Coupon;
use Modules\Apps\Http\Controllers\Api\ApiController;

class CouponController extends ApiController
{

    function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function checkCoupon(Request $request)
    {
        $coupon =  $this->coupon->checkCoupon($request);

        if ($coupon)
            return new CouponResource($coupon);

        return $this->response([]);
    }
}
