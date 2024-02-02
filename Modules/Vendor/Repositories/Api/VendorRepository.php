<?php

namespace Modules\Vendor\Repositories\Api;

use Modules\Vendor\Entities\Vendor;
use Modules\Vendor\Entities\VendorSeller;
use Modules\Vendor\Entities\VendorArea;
use Illuminate\Support\Facades\Log;


class VendorRepository
{
    function __construct(Vendor $vendor,VendorArea $vendorArea, VendorSeller $vendorSeller)
    {
        $this->vendor = $vendor;
        $this->vendorArea = $vendorArea;
        $this->vendorSeller = $vendorSeller;
    }

    public function getAllActive($request)
    {
        $vendors = $this->vendor->with(['images'])->whereHas('areas', function($query) use($request){
                        $query->where('areas.id',$request['area_id']);
                   });

        if ($request['section_id']) {
             $vendors->whereHas('sections', function($query) use($request){
                  $query->where('sections.id',$request['section_id']);
             });
        }

        if ($request['category_id']) {
             $vendors->whereHas('products', function($query) use($request) {
                  $query->whereHas('categories', function($query) use($request) {
                      $query->whereIn('categories.id',$request['category_id']);
                  });
             });
        }

        return $vendors->active()->orderBy('id', 'DESC')->get();
    }

    public function findById($id)
    {
        $vendor = $this->vendor->with(['images'])->active()->where('id',$id)->first();
        return $vendor;
    }

    // public function getVendorId()
    // {
    //     $userId = auth()->id();
    //     $SellerId = $this->vendorSeller->where('seller_id', $userId)->first();

    //     if ($SellerId) {
    //         $vendorId = $SellerId->vendor_id;
    //         return $vendorId;
    //     }
    //     else {
    //         return null;
    //     }
    // }

    public function getArea($areaId, $vendorId) {
        // Check if a record already exists for the given vendor and area
        $vendorArea = $this->vendorArea->where('vendor_id', $vendorId)
                                ->where('area_id', $areaId)
                                ->first();
        return $vendorArea;
    }

    public function getPriceAreaData($request, $vendorId)
    {
        $results = [];
        $shippingPrices = $request->input('shipping_prices');

        foreach ($shippingPrices as $areaId => $shippingPriceData) {
            $shippingPrice = (float) $shippingPriceData['price'];
            $vendorArea = $this->getArea($areaId, $vendorId);
            // Add the data to the result array
            $results[] = [$shippingPrice, $areaId, $vendorId, $vendorArea];
        }
        return $results;
    }

    public function createVendorAreas($results)
    {
        foreach($results as $result){
            $vendorAreasObj = new VendorArea();
            $vendorAreasObj->vendor_id = $result[2];
            $vendorAreasObj->area_id = $result[1];
            $vendorAreasObj->shipping_price =  $result[0];
            $vendorAreasObj->save();
        }
        return $vendorAreasObj;
    }
}
