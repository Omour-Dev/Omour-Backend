<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id'  => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'mobile'        => $this->mobile,
            'role'          => $this->roles,
            'image'         => url($this->image),
        ];
    }
}
