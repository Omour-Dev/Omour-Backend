<?php

namespace Modules\Order\Traits;

use Modules\Cart\Traits\CartTrait;
use Modules\Variation\Entities\Option;
use Modules\Attribute\Entities\Attribute;
use Modules\Product\Entities\Product;
use Modules\User\Entities\UserAddress;
use Modules\Attribute\Entities\AttributeValue;

trait OrderCalculationTrait
{
    use CartTrait;

    public function calculateTheOrder($data)
    {
        // return $cart = $this->cartDetails($data);
        $cart = $this->cartDetails($data);

        $subtotal           = 0.000;
        $total              = 0.000;
        $attribute_prices   = 0.000;
        $options            = null;
        $attributes         = null;

        foreach ($cart as $key => $product) {

            $orderProducts['product']    = Product::find($key);
            $orderProducts['qty']        = $product['quantity'];
            $orderProducts['price']      = $product['price'];
            $orderProducts['total']      = $product['price'] * $product['quantity'];

            if (!is_null($product['attributes']['options'])) {

                foreach (collect($product['attributes']['options']) as $productOption) {

                    foreach ($productOption['option_values'] as $value) {
                        $valuesIds[] = collect($value)['id'];
                    }

                }

                $options = Option::with([
                    'values' => function ($query) use($valuesIds){
                        $query->whereIn('id',$valuesIds);
                    }
                ])->whereHas('values', function($query) use($valuesIds) {
                    $query->whereIn('id',$valuesIds);
                })->get();

            }

            if (!is_null($product['attributes']['additional'])) {

                foreach (collect($product['attributes']['additional']) as $key => $productAdditional) {

                    foreach ($productAdditional['attribute_values'] as $addtionalValue) {
                        $addtionalValuesIds[] = collect($addtionalValue)['id'];
                    }

                    $attribute_prices  += $productAdditional['attribute_values'][$key]['price'];
                }

                $attributes = Attribute::with([
                    'values' => function ($query) use($addtionalValuesIds){
                        $query->whereIn('id',$addtionalValuesIds);
                    }
                ])->whereHas('values', function($query) use($addtionalValuesIds) {
                    $query->whereIn('id',$addtionalValuesIds);
                })->get();

            }


            $orderProducts['options']    = $options;
            $orderProducts['attributes'] = $attributes;
            $subtotal    += $orderProducts['total'];
            $total       += $orderProducts['total'];
            $products[]   = $orderProducts;
        }

        return $data = [
            'subtotal'          => $subtotal,
            'total'             => $total + $attribute_prices,
            'vendor_id'         => $this->getVendor($data),
            'order_products'    => $products,
            'address'           => $this->address($data)
        ];

        return $subtotal;
    }

    public function address($data)
    {
        $address = UserAddress::find($data['address_id']);

        return [
            'floor'     => $address['floor'],
            'building'  => $address['building'],
            'door'      => $address['door'],
            'street'    => $address['street'],
            'address'   => $address['address'],
            'area_id'   => $address['area_id'],
            'username'  => $address['username'],
            'mobile'    => $address['mobile'],
            'email'     => $address['email'],
        ];
    }
}
