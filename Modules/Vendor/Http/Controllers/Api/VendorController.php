<?php

namespace Modules\Vendor\Http\Controllers\Api;

use Illuminate\Http\Request;
// use Modules\Vendor\Http\Requests\Api\AddShippingPriceRequest;
use Modules\Vendor\Entities\VendorArea;
use Modules\Vendor\Transformers\Api\VendorResource;
use Modules\Vendor\Repositories\Api\VendorRepository;
use Modules\Apps\Http\Controllers\Api\ApiController;

class VendorController extends ApiController
{

    function __construct(VendorRepository $vendor, VendorArea $vendorArea)
    {
        $this->vendor = $vendor;
        $this->vendorArea = $vendorArea;
    }

    public function vendors(Request $request)
    {
        $vendors =  $this->vendor->getAllActive($request);

        return VendorResource::collection($vendors);
    }

    public function vendor($id)
    {
        $vendor = $this->vendor->findById($id);

        if(!$vendor)
          return $this->response([]);

        return $this->response(new VendorResource($vendor));
    }

    public function addShippingPrice(Request $request)
    {
        try {
            // if(!$vendorId)// handle return $this->response(new VendorResource($vendor));
            $shippingPrice = (float) $request->input('shipping_price');

            $vendorId = $this->vendor->getVendorId();
            $areaId = $this->vendor->getArea($request, $vendorId);

            $this->vendorArea->create([
                    'vendor_id'      => $vendorId,
                    'area_id'        => $areaId,
                    'shipping_price' => $shippingPrice,
                ]);
                return response()->json(['message' => 'Shipping price added successfully']);
        }
        catch (\Exception $e){
            \Log::error('handleError ' . $e->getMessage());
            return response()->json(['details' => $e->getMessage()], 500);
        }
    }

    public function UpdateShippingPrice(Request $request)
    {

        // if ($vendorArea) {
        //     $vendorArea->update(['shipping_price' => $shippingPrice]);
        // }
    }
}
