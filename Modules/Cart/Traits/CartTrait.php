<?php

namespace Modules\Cart\Traits;

use Cart;
use Illuminate\Support\MessageBag;
use Darryldecode\Cart\CartCondition;
use Modules\Variation\Transformers\Api\OptionResource;
use Modules\Attribute\Transformers\Api\AttributeResource;

trait CartTrait
{
    public function getCart($userId)
    {
        return Cart::session($userId);
    }

    public function getVendor($data)
    {
        $cart = $this->getCart($data['user_token']);

        $vendor = $cart->getCondition('vendor')->getType();

        return $vendor;
    }

    public function vendorValidation($data, $product)
    {
        $errors = null;

        $cart = $this->getCart($data['user_token']);

        $vendor = $cart->getCondition('vendor');

        if ($vendor) {
            if ($vendor->getType() != $product->vendor_id)
                return $errors = new MessageBag([
                    'cart' => __('cart::api.validation.cart.vendor_not_match')
                ]);
        }

        return $errors;
    }

    public function addToCart($data, $item)
    {
        $cart = $this->getCart($data['user_token']);

        $cart->add([
            'id' => $item['product']['id'],
            'name'        => $item['product']->translate(locale())->title,
            'price'       => $item['product']['offer'] ?  $item['product']['offer']['offer_price'] : $item['product']['price'],
            'quantity'    => $data['qty'] ? $data['qty'] : +1,
            'attributes'  => [
                'type'        => 'simple',
                'image'       => url($item['product']['image']),
                'translation' => $item['product']['translations'],
                'options'     => $item['options']  ? OptionResource::collection($item['options']) : null,
                'additional'  => $item['attributes']  ? AttributeResource::collection($item['attributes']) : null,
            ]
        ]);

        $orderVendor = new CartCondition([
            'name'  => 'vendor',
            'type'  => $item['product']['vendor_id'],
            'value' => 0.000,
        ]);

        $cart->condition([$orderVendor]);

        return true;
    }

    public function removeItem($data, $id)
    {
        $cart = $this->getCart($data['user_token']);
        return $cart->remove($id);
    }

    public function clearCart($data)
    {
        $cart = $this->getCart($data['user_token']);
        $cart->clear();
        $cart->clearCartConditions();

        return true;
    }

    public function cartDetails($data)
    {
        $cart = $this->getCart($data['user_token']);

        $items = [];

        return $cart->getContent()->each(function ($item) use (&$items) {
            $items[] = $item;
        });
    }



    public function cartTotal($data)
    {
        $cart = $this->getCart($data['user_token']);

        return $cart->getTotal();
    }
}