<?php

namespace Modules\Vendor\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Vendor\Transformers\Api\VendorResource;
use Modules\Vendor\Transformers\Api\VendorAreaResource;
use Modules\Vendor\Repositories\Api\VendorRepository;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Log;

class VendorController extends ApiController
{

    function __construct(VendorRepository $vendor, VendorRepository $vendorRepoObj)
    {
        $this->vendor = $vendor;
        $this->vendorRepoObj = $vendorRepoObj;
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

    public function addShippingPrice(Request $request, $vendorId)
    {
        $results = $this->vendor->getPriceAreaData($request, $vendorId);

        if ( $vendorId == null) {
            return response()->json(['error' => 'This vendor admin does not have a vendor shop'], 404);
        }
        if($results[0][3] == null){
            $vendorAreasObj = $this->vendorRepoObj->createVendorAreas($results);
            return new VendorAreaResource($vendorAreasObj);
        }
        else{
            return response()->json(['message' => 'there are already shipping price for this area']);
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
