<?php

namespace Modules\Variation\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    protected $fillable = ['product_option_id','option_value_id'];

    public function value()
    {
        return $this->belongsTo(OptionValue::class , 'option_value_id');
    }

}
