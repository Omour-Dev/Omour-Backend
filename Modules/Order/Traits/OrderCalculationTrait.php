<?php

namespace Modules\Order\Traits;

use Modules\Cart\Traits\CartTrait;
use Modules\Variation\Entities\Option;
use Modules\Attribute\Entities\Attribute;
use Modules\Product\Entities\Product;
use Modules\User\Entities\UserAddress;
use Illuminate\Http\Request;
use Modules\Attribute\Entities\AttributeValue;
use Modules\Vendor\Entities\VendorArea;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Exception;


trait OrderCalculationTrait
{
    use CartTrait;

    protected function getShippingPrice($areaId)
    {
        // Fetch shipping price from VendorArea based on area_id
        $vendorArea = VendorArea::where('area_id', $areaId)->first();

        return $vendorArea ? $vendorArea->shipping_price : 15;
    }

    protected function getUserArea($data)
    {
        if ($data['user_token']) {
            return $this->handleError("User not authenticated");
        } else {
            $address = $user->addresses->first();

            if (!$address){
                return $this->handleError("User has no assigned address");
            }else{
                $areaId = $address->area_id;
                return $areaId;
            }
        }
    }

    protected function handleError($message)
    {
        return ['error' => $message];
    }

    public function calculateTheOrder($data)
    {

        $cart = $this->cartDetails($data);
        $areaId = $this->getUserArea($data);

        $subtotal           = 0.000;
        $total              = 0.000;
        $attribute_prices   = 0.000;
        $options            = null;
        $attributes         = null;
        $shippingPrice = $this->getShippingPrice($areaId);
        $products = [];

        foreach ($cart as $key => $product) {

            $orderProducts['product']    = Product::find($key);
            $orderProducts['qty']        = $product['quantity'];
            $orderProducts['price']      = $product['price'];
            $orderProducts['total']      = $shippingPrice + $product['price'] * $product['quantity'] ;

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
            'address'           => $this->address($data),
            'shipping_price'    => $shippingPrice
        ];

    }

    public function address($data)
    {
        $areaId = $this->getUserArea($data);
        $address = UserAddress::where('area_id', $areaId)->first();
        if (!$address) {
            return ['error' => 'Address not found for the specified area.'];
        }
        else {
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

}
