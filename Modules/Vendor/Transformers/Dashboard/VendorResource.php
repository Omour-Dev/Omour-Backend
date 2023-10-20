<?php

namespace Modules\Vendor\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\Resource;

class VendorResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id'  => $this->id,
            'image'         => url($this->image),
            'title'         => $this->translate(locale())->title,
            'status'        => $this->status,
            'deleted_at'    => $this->deleted_at,
            'created_at'    => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
