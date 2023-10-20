<?php

namespace Modules\Product\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
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
            'image'         => url($this->image),
            'title'         => $this->translate(locale())->title,
            'status'        => $this->status,
            'qty'           => $this->qty,
            'deleted_at'    => $this->deleted_at,
            'created_at'    => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
