<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class UserAddressResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id'  => $this->id,
            'username'      => $this->username,
            'email'         => $this->email,
            'mobile'        => $this->mobile,
            'door'          => $this->door,
            'floor'         => $this->floor,
            'street'        => $this->street,
            'building'      => $this->building,
            'address'       => $this->address,
            'area_id'       => $this->area->id,
            'area'          => $this->area->translate(locale())->title,
        ];
    }
}
