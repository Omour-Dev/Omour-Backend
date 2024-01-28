<?php

namespace Modules\Vendor\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Vendor\Entities\VendorArea;
use Modules\Vendor\Transformers\Api\VendorResource;
use Modules\Vendor\Transformers\Api\VendorAreaResource;
use Modules\Vendor\Repositories\Api\VendorRepository;
use Modules\Apps\Http\Controllers\Api\ApiController;

class VendorController extends ApiController
{

    function __construct(VendorRepository $vendor, VendorArea $vendorArea)
    {
        $this->vendor = $vendor;
        $this->vendorAreaObj = $vendorArea;
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
        try{
            // if(!$vendorId)// handle return $this->response(new VendorResource($vendor));
            [$shippingPrice, $areaId, $vendorId, $vendorArea] = $this->vendor->getPriceAreaData($request);

            if($vendorArea == null){
                $this->vendorAreaObj->vendor_id = $vendorId;
                $this->vendorAreaObj->area_id = $areaId;
                $this->vendorAreaObj->shipping_price = $shippingPrice;
                $this->vendorAreaObj->save();
                return new VendorAreaResource($this->vendorAreaObj);
            }
            else{
                return response()->json(['message' => 'there are already shipping price for this area']);
            }
        }
        catch (\Exception $e){
            \Log::error('handleError ' . $e->getMessage());
            return response()->json(['details' => $e->getMessage()], 500);
        }

    }

    public function UpdateShippingPrice(Request $request)
    {
        [$shippingPrice, $areaId, $vendorId, $vendorArea] = $this->vendor->getPriceAreaData($request);
        if ($vendorArea != null) {
            $vendorArea->update(['shipping_price' => $shippingPrice]);
            $vendorArea->save();
            return new VendorAreaResource($vendorArea);
            }
        else{
            return response()->json(['message' => 'there is no area id with this number']);
        }
    }
}
