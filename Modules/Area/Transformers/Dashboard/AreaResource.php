<?php

namespace Modules\Area\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\Resource;

class AreaResource extends Resource
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
            'status'        => $this->status,
            'state_id'      => $this->state->translate(locale())->title,
            'deleted_at'    => $this->deleted_at,
            'created_at'    => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
