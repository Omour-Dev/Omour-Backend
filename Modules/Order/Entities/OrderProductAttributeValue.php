<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Product;
use Modules\Attribute\Entities\AttributeValue;

class OrderProductAttributeValue extends Model
{
    protected $fillable = [
      'order_product_attribute_id',
      'attribute_value_id',
      'price',
      'qty',
      'total',
    ];

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }
}
