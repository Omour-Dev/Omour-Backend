<?php

namespace Modules\Product\Repositories\Dashboard;

use Modules\Core\Traits\SyncRelationModel;
use Modules\Product\Entities\Product;
use Hash;
use DB;

class ProductRepository
{
    use SyncRelationModel;
    public $product;

    function __construct(Product $product)
    {
        $this->product   = $product;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $products = $this->product->orderBy($order, $sort)->get();
        return $products;
    }

    public function findById($id)
    {
        $product = $this->product->withDeleted()->find($id);
        return $product;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $product = $this->product->create([
                'image'         => path_without_domain($request->image),
                'status'        => $request->status ? 1 : 0,
                'price'         => $request->price,
                'qty'           => $request->qty,
                'sku'           => $request->sku,
                'vendor_id'     => $request->vendor_id,
            ]);

            $this->translateTable($product, $request);

            $product->categories()->sync(int_to_array($request->category_id));
            $this->productNewArrival($product, $request);
            $this->productImages($product, $request);
            $this->productOffer($product, $request);
            $this->productVariants($product, $request);
            $this->productAttributes($product, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        $product = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($product) : null;

        try {

            $product->update([
                'image'         => $request->image ? path_without_domain($request->image) : $product->image,
                'status'        => $request->status ? 1 : 0,
                'price'         => $request->price,
                'qty'           => $request->qty,
                'sku'           => $request->sku,
                'vendor_id'     => $request->vendor_id,
            ]);

            $this->translateTable($product, $request);

            $product->categories()->sync(int_to_array($request->category_id));
            $this->productNewArrival($product, $request);
            $this->productImages($product, $request);
            $this->productOffer($product, $request);
            $this->productVariants($product, $request);
            $this->productAttributes($product, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function productImages($model, $request)
    {
        $model->images()->delete();

        if ($request['images']) {
            foreach ($request['images'] as $value) {

                if (!is_null($value)) {

                    $model->images()->create([
                        'image'  => path_without_domain($value),
                    ]);
                }
            }
        }
    }

    public function productVariants($model, $request)
    {
        if ($model->productOptions) {
            $model->productOptions()->delete();
        }

        if ($request['option_id']) {

            foreach ($request['option_id'] as $id => $optionValues) {
                $option = $model->productOptions()->updateOrCreate(
                    [
                        'option_id' => $id,
                    ],
                    [
                        'option_id'  => $id,
                    ]
                );

                foreach ($optionValues as $key => $value) {
                    if ($value != null) {
                        $value = $option->productOptionValues()->updateOrCreate(
                            [
                                'option_value_id'   => $value,
                            ],
                            [
                                'option_value_id'  => $value,
                            ]
                        );
                    } else {
                        $option->delete();
                    }
                }
            }
        }
    }



    public function productAttributes($model, $request)
    {
        if ($model->productAttributes) {
            $model->productAttributes()->delete();
        }

        if ($request['attribute_id']) {

            foreach ($request['attribute_id'] as $id => $attributeValues) {
                $attribute = $model->productAttributes()->updateOrCreate(
                    [
                        'attribute_id' => $id,
                    ],
                    [
                        'attribute_id'  => $id,
                    ]
                );

                foreach ($attributeValues as $key => $value) {
                    if ($value != null) {
                        $value = $attribute->productAttributeValues()->updateOrCreate(
                            [
                                'attribute_value_id'   => $value,
                            ],
                            [
                                'attribute_value_id'  => $value,
                            ]
                        );
                    } else {
                        $attribute->delete();
                    }
                }
            }
        }
    }

    public function productOffer($model, $request)
    {
        if (isset($request['offer_status']) && $request['offer_status'] == 'on') {

            $model->offer()->updateOrCreate(
                ['product_id' => $model->id],
                [
                    'status'        => ($request['offer_status'] == 'on') ? true : false,
                    'offer_price'   => $request['offer_price'] ? $request['offer_price'] : $model->offer->offer_price,
                    'start_at'      => $request['start_at'] ? $request['start_at'] : $model->offer->start_at,
                    'end_at'        => $request['end_at'] ? $request['end_at'] : $model->offer->end_at,
                ]
            );
        } else {
            if ($model->offer) {
                $model->offer()->delete();
            }
        }
    }

    public function productNewArrival($model, $request)
    {
        if (isset($request['arrival_status']) && $request['arrival_status'] == 'on') {

            $model->arrival()->updateOrCreate(
                ['product_id' => $model->id],
                [
                    'status'        => ($request['arrival_status'] == 'on') ? true : false,
                    'start_at'      => $request['arrival_start_at'] ? $request['arrival_start_at'] : $model->newArrival->start_at,
                    'end_at'        => $request['arrival_end_at'] ? $request['arrival_end_at'] : $model->newArrival->end_at,
                ]
            );
        } else {
            if ($model->newArrival) {
                $model->arrival()->delete();
            }
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function translateTable($model, $request)
    {
        foreach ($request['title'] as $locale => $value) {
            $model->translateOrNew($locale)->title           = $value;
            $model->translateOrNew($locale)->description     = $request['description'][$locale];
            // $model->translateOrNew($locale)->seo_description = $request['seo_description'][$locale];
            // $model->translateOrNew($locale)->seo_keywords    = $request['seo_keywords'][$locale];
        }

        $model->save();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()) :
                $model->forceDelete();
            else :
                $model->delete();
            endif;

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->product->with(['translations'])
            ->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('sku', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('price', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere(function ($query) use ($request) {
                    $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('title', 'like', '%' . $request->input('search.value') . '%');
                        $query->where('slug', 'like', '%' . $request->input('search.value') . '%');
                    });
                });
            });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search Categories by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at', '>=', $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at', '<=', $request['req']['to']);

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();

        if (isset($request['req']['vendor']))
            $query->where('vendor_id', $request['req']['vendor']);

        return $query;
    }
}
