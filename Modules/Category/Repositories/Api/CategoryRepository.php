<?php

namespace Modules\Category\Repositories\Api;

use Modules\Category\Entities\Category;

class CategoryRepository
{
    function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAllCategories($request)
    {
        $categories = $this->category->mainCategories()->with([
            'products' => function ($query) use ($request) {
                $query
                    ->with([
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
                    ])->whereHas('vendor', function ($query) use ($request) {
                        $query->where('vendor_id', $request['vendor_id']);
                    });

                if ($request['categories']) {
                    $query->whereHas('categories', function ($query) use ($request) {
                        $query->whereIn('categories.id', $request->categories);
                    });
                }

                if ($request['low_price'] && $request['high_price']) {
                    $query->whereBetween('price', [$request['low_price'], $request['high_price']]);
                }

                if ($request['search']) {
                    $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('description', 'like', '%' . $request['search'] . '%');
                        $query->where('title', 'like', '%' . $request['search'] . '%');
                        $query->where('slug', 'like', '%' . $request['search'] . '%');
                    });
                }
            }
        ])->active()->orderBy('id', 'DESC')->get();

        return $categories;
    }
}
