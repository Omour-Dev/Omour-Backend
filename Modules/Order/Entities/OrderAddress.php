<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $fillable = [
        'email','username','mobile','floor', 'door' , 'street','building','address','area_id','order_id'
    ];

    public function area()
    {
        return $this->belongsTo(\Modules\Area\Entities\Area::class);
    }
}
