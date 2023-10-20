<?php

namespace Modules\Product\Rules;

use Modules\Product\Entities\Product;
use Illuminate\Contracts\Validation\Rule;

class SkuUnique implements Rule
{
    public $vendor_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($vendor_id)
    {
        $this->vendor_id = $vendor_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $product =Product::where('sku', $value)->where('vendor_id', $this->vendor_id)->first();
        if ($product) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        //value already exists for this sku with this vendor
        return __('product::dashboard.products.validation.sku_unique');
    }
}
