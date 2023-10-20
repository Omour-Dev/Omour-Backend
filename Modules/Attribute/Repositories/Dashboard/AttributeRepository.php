<?php

namespace Modules\Attribute\Repositories\Dashboard;

use Modules\Attribute\Entities\AttributeValue;
use Modules\Attribute\Entities\Attribute;
use Hash;
use DB;

class AttributeRepository
{

    function __construct(Attribute $attribute, AttributeValue $value)
    {
        $this->value       = $value;
        $this->attribute   = $attribute;
    }

    public function findAttributeByVendor($vendorId)
    {
        $attributes = $this->attribute->with(['values'])->where('vendor_id', $vendorId)->orderBy('id', 'DESC')->get();
        return $attributes;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $attributes = $this->attribute->orderBy($order, $sort)->get();
        return $attributes;
    }

    public function getAllValues($order = 'id', $sort = 'desc')
    {
        $values = $this->value->orderBy($order, $sort)->get();
        return $values;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $attributes = $this->attribute->with(
            [
                'values' => function ($query) {
                    $query->active();
                }
            ]
        )->whereHas('values', function ($query) use ($vendor) {
            $query->active();
        })->active()->orderBy($order, $sort)->get();

        return $attributes;
    }

    public function getAllActiveHasValues($order = 'id', $sort = 'desc')
    {
        $attributes = $this->attribute->with('values')->active()->orderBy($order, $sort)->get();
        return $attributes;
    }

    public function findByAttributeId($attributeId)
    {
        $values = $this->value->where('attribute_id', $attributeId)->get();
        return $values;
    }

    public function findByAttributeValuesId($attributeIds)
    {
        $values = $this->value->whereIn('id', $attributeIds)->get()->groupBy('attribute_id');
        return $values;
    }

    public function findAttributeValueById($id)
    {
        $attribute = $this->value->find($id);
        return $attribute;
    }

    public function findById($id)
    {
        $attribute = $this->attribute->with(['values'])->find($id);
        return $attribute;
    }

    public function findBySlug($slug)
    {
        $attribute = $this->attribute->whereTranslation('slug', $slug)->first();

        return $attribute;
    }

    public function checkRouteLocale($model, $slug)
    {
        if ($model->translate()->where('slug', $slug)->first()->locale != locale())
            return false;

        return true;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $attribute = $this->attribute->create([
                'status'        => $request->status ? 1 : 0,
                'code'          => $request->code,
                'vendor_id'     => $request->vendor_id
            ]);

            $this->translateTable($attribute, $request);

            $this->createValues($attribute, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function createValues($attribute, $request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['attribute_value_status'] as $key => $attributeValueStatus) {

                $value = $attribute->values()->create([
                    'status' => $attributeValueStatus,
                    'price'  => $request['attribute_value_price'][$key]
                ]);

                foreach ($request['attribute_value_title'] as $locale => $attributeValueTitle) {
                    $value->translateOrNew($locale)->title  = $attributeValueTitle[$key];
                }

                $value->save();
            }

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

        $attribute = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($attribute) : null;

        try {

            $attribute->update([
                'status'   => $request->status ? 1 : 0,
                'code'     => $request->code,
                'vendor_id'     => $request->vendor_id
            ]);

            $this->translateTable($attribute, $request);

            $this->updateValues($attribute, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateValues($attribute, $request)
    {
        DB::beginTransaction();

        $attribute->values()->whereNotIn('id', array_values($request['attribute_values_ids']))->delete();

        try {

            foreach ($request['attribute_value_status'] as $key => $attributeValueStatus) {

                if (isset($request['attribute_values_ids'][$key])) {

                    $value = $attribute->values()->where('id', $request['attribute_values_ids'][$key])->updateOrCreate([
                        'status' => $attributeValueStatus,
                    ]);
                } else {

                    $value = $attribute->values()->create([
                        'status' => $attributeValueStatus,
                    ]);
                }

                foreach ($request['attribute_value_title'] as $locale => $attributeValueTitle) {
                    $value->translateOrNew($locale)->title  = $attributeValueTitle[$key];
                }

                $value->save();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
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
        }

        $model->save();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            $model->delete();

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
        $query = $this->attribute->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhereHas('translations', function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->input('search.value') . '%');
                });
            });
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search Attributes by Created Dates
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

        return $query;
    }
}
