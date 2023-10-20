<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;

class OrderProduct extends Model
{

    // protected $with = ['product'];

    protected $fillable = [
      'price',
      'off',
      'qty',
      'total',
      'product_id',
      'order_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function orderProductOptions()
    {
        return $this->hasMany(OrderProductOption::class);
    }

    public function orderProductAttributes()
    {
        return $this->hasMany(OrderProductAttribute::class);
    }
}
