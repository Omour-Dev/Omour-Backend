<?php

namespace Modules\Attribute\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\Resource;

class AttributeResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'  => $this->id,
            'title'         => $this->translate(locale())->title,
            'code'          => $this->code,
            'vendor_id'     => $this->vendor->translate(locale())->title,
            'status'        => $this->status,
            'deleted_at'    => $this->deleted_at,
            'created_at'    => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
