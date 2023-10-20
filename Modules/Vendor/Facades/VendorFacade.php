<?php

namespace Modules\Vendor\Facades;

use Modules\Vendor\Entities\Vendor;

class VendorFacade
{
    static protected function vendor()
    {
        if (auth()->user()) {

            return Vendor::whereHas('sellers', function($query) {
                $query->where('seller_id', auth()->user()->id);
            })->first();

        }

        return false;
    }

    static public function data()
    {
        $vendor = self::vendor();

        if ($vendor)
            return $vendor;

        return false;
    }

    static public function id()
    {
        $vendor = self::vendor();

        if ($vendor)
            return $vendor->id;

        return false;
    }

    static public function logo()
    {
        $vendor = self::vendor();

        if ($vendor)
            return url($vendor->image);

        return false;
    }

    static public function title()
    {
        $vendor = self::vendor();

        if ($vendor)
            return $vendor->translate(locale())->title;

        return false;
    }
}
