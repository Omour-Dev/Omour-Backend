<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderRate extends Model
{
    protected $fillable = [
        'order_rate','service_rate','vendor_rate','delivery_rate','vendor_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
