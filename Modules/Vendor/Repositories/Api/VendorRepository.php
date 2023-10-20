<?php

namespace Modules\Vendor\Repositories\Api;

use Modules\Vendor\Entities\Vendor;

class VendorRepository
{
    function __construct(Vendor $vendor)
    {
        $this->vendor   = $vendor;
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
}
