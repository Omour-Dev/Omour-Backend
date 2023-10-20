<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Order extends Model
{
    use SoftDeletes , ScopesTrait;

    protected $fillable = [
      'unread',
      'is_holding',
      'is_finished',
      'subtotal',
      'discount',
      'total',
      'user_id',
      'vendor_id',
      'order_status_id',
    ];

    public function vendor()
    {
        return $this->belongsTo(\Modules\Vendor\Entities\Vendor::class);
    }

    public function user()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function address()
    {
        return $this->hasOne(OrderAddress::class);
    }

    public function rate()
    {
        return $this->hasOne(OrderRate::class);
    }

    public function driver()
    {
        return $this->hasOne(OrderDriver::class);
    }
}
