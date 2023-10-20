<?php

namespace Modules\Vendor\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Vendor\Transformers\Api\VendorResource;
use Modules\Vendor\Repositories\Api\VendorRepository as Vendor;
use Modules\Apps\Http\Controllers\Api\ApiController;

class VendorController extends ApiController
{

    function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
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
}
