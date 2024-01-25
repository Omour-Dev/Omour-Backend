<?php

namespace Modules\Product\Repositories\Api;

use Modules\Attribute\Entities\Attribute;
use Modules\Variation\Entities\Option;
use Modules\Product\Entities\Product;

class ProductRepository
{
    function __construct(Product $product, Option $option, Attribute $attribute)
    {
        $this->product      = $product;
        $this->option       = $option;
        $this->attribute    = $attribute;
    }

    public function getAllProductsByVendor($request)
    {
        $products = $this->product->active()->with([
            'arrival' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'offer' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'productOptions' => function ($query) {
                $query->with(['option', 'productOptionValues.value']);
            },
            'productAttributes' => function ($query) {
                $query->with(['attribute', 'productAttributeValues.value']);
            },
            'images'
        ]);

        if ($request['vendor_id']) {
            $products->whereHas('vendor', function ($query) use ($request) {
                $query->where('vendor_id', $request['vendor_id']);
            });
        }

        if ($request['categories']) {

            $products->whereHas('categories', function ($query) use ($request) {
                $query->whereIn('categories.id', $request->categories);
            });
        }

        if ($request['low_price'] && $request['high_price']) {
            $products->whereBetween('price', [$request['low_price'], $request['high_price']]);
        }

        if ($request['search']) {
            $products->whereHas('translations', function ($query) use ($request) {

                $query->where('description', 'like', '%' . $request['search'] . '%');
                $query->where('title', 'like', '%' . $request['search'] . '%');
                $query->where('slug', 'like', '%' . $request['search'] . '%');
            });
        }

        return $products->orderBy('id', 'DESC')->paginate(48);
    }

    public function findById($request)
    {

        $options    = null;
        $attributes = null;

        $product = $this->product->active()->where('id', $request)->first();

        if (isset($request['product_option_values'])) {
            $options = $this->option->with([
                'values' => function ($query) use ($request) {
                    $query->whereIn('id', $request['product_option_values']);
                }
            ])->whereHas('values', function ($query) use ($request) {
                $query->whereIn('id', $request['product_option_values']);
            })->get();
        }

        if (isset($request['product_attributes_values'])) {
            $attributes = $this->attribute->with([
                'values' => function ($query) use ($request) {
                    $query->whereIn('id', $request['product_attributes_values']);
                }
            ])->whereHas('values', function ($query) use ($request) {
                $query->whereIn('id', $request['product_attributes_values']);
            })->get();
        }

        return ['product' => $product, 'options' => $options, 'attributes' => $attributes];
    }
}
