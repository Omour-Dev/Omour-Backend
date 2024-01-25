<?php

namespace Modules\Cart\Traits;

use Cart;
use Illuminate\Support\MessageBag;
use Darryldecode\Cart\CartCondition;
use Modules\Variation\Transformers\Api\OptionResource;
use Modules\Attribute\Transformers\Api\AttributeResource;

trait CartTrait
{
    public function getCart(string $userId)
    {
        return Cart::session($userId);
    }

    public function getVendor($data)
    {
        $cart = $this->getCart($data['user_token']);

        $vendorCondition = $cart->getCondition('vendor');

        if ($vendorCondition) {
            return $vendorCondition->getType();
        }

        return null; // or handle the case where the condition doesn't exist
}

    public function vendorValidation($data, $product)
    {
        $errors = null;
        // TODO: heloo -> auth()->id()
        $cart = $this->getCart(1);
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
        $cart = $this->getCart(1);
        // dd(str(url($item['product']['image'])));

        $cart->add([
            'id' => $item['product']['id'],
            'name'        => $item['product']->title,
            'price'       => ($item['product']['offer'] ?  $item['product']['offer']['offer_price'] : $item['product']['price'])??1,
            'quantity'    => $data['qty'] ? $data['qty'] : +1,
            'attributes'  => [
                'type'        => 'simple',
                // 'image'       => url($item['product']['image']),
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
        $cartCollection = Cart::getContent();
        $cartCollection->toJson();

        return $cartCollection;
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
        $cart = $this->getCart("hello");

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
