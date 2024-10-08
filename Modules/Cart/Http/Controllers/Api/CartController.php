<?php

namespace Modules\Cart\Http\Controllers\Api;

use Cart;
use Modules\Cart\Traits\CartTrait;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Darryldecode\Cart\CartCondition;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Product\Repositories\Api\ProductRepository as Product;

class CartController extends ApiController
{
    use CartTrait;

    function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(Request $request)
    {
        return $this->response([
            'items' => array_values(collect($this->cartDetails($request))->toArray()),
            'total' => $this->cartTotal($request)
        ]);
    }

    public function add(Request $request)
    {
        $data = $this->product->findById($request);

        $vendorCheck = $this->vendorValidation($request,$data['product']);

        if (!is_null($vendorCheck)) {
            return $this->invalidData($vendorCheck);
        }

        $this->addToCart($request,$data);

        return $this->response([
            'items' => array_values(collect($this->cartDetails($request))->toArray()),
            'total' => $this->cartTotal($request)
        ]);
    }

    public function remove(Request $request,$id)
    {
        $this->removeItem($request,$id);

        return $this->response([
            'items' => array_values(collect($this->cartDetails($request))->toArray()),
            'total' => $this->cartTotal($request)
        ]);
    }

    public function clear(Request $request)
    {
        $this->clearCart($request);

        return $this->response([
            'items' => array_values(collect($this->cartDetails($request))->toArray()),
            'total' => $this->cartTotal($request)
        ]);
    }
}
