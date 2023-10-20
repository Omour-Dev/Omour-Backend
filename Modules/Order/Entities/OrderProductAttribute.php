<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Product;
use Modules\Attribute\Entities\Attribute;

class OrderProductAttribute extends Model
{
    protected $fillable = [
      'order_product_id',
      'attribute_id',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function orderProductAttributeValues()
    {
        return $this->hasMany(OrderProductAttributeValue::class);
    }
}
