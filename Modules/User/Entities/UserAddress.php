<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'email','username','mobile','floor', 'door' , 'street','building','address','area_id','user_id'
    ];

    public function area()
    {
        return $this->belongsTo(\Modules\Area\Entities\Area::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
