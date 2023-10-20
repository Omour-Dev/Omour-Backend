<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderDriver extends Model
{
    protected $fillable = [
        'driver_id','order_id'
    ];

    public function driver()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class,'driver_id','id');
    }

    public function order()
    {
        return $this->belongsTo(\Modules\Order\Entities\Order::class,'order_id','id');
    }
}
