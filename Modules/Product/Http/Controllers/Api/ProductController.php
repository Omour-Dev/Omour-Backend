<?php

namespace Modules\Product\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Product\Transformers\Api\ProductResource;
use Modules\Product\Transformers\Api\ProductVariantResource;
use Modules\Product\Repositories\Api\ProductRepository as Product;

class ProductController extends ApiController
{
    function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function products(Request $request)
    {
        $products =  $this->product->getAllProductsByVendor($request);

        return ProductResource::collection($products);
    }

    public function productVariation(Request $request)
    {
        $variatne =  $this->product->productWithVariations($request);

        if(!$variatne)
          return $this->response([]);

        return $this->response(new ProductVariantResource($variatne));
    }
}
