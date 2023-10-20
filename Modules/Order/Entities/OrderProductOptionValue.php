<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Product;
use Modules\Variation\Entities\OptionValue;

class OrderProductOptionValue extends Model
{
    protected $fillable = [
      'order_product_option_id',
      'option_value_id',
    ];

    public function optionValue()
    {
        return $this->belongsTo(OptionValue::class);
    }
}
