<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Product;
use Modules\Variation\Entities\Option;

class OrderProductOption extends Model
{
    protected $fillable = [
      'order_product_id',
      'option_id',
    ];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function orderProductOptionValues()
    {
        return $this->hasOne(OrderProductOptionValue::class);
    }
}
