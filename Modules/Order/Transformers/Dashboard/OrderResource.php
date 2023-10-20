<?php

namespace Modules\Order\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\Resource;

class OrderResource extends Resource
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
            'id'         => $this->id,
            'subtotal'             => $this->subtotal,
            'discount'             => $this->discount,
            'total'                => $this->total,
            'date'                 => $this->date,
            'vendor'               => $this->vendor->translate(locale())->title,
            'user'                 => $this->user->name,
            'order_status_id'      => $this->orderStatus->translate(locale())->title,
            'deleted_at'           => $this->deleted_at,
            'created_at'           => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
