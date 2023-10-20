<?php

namespace Modules\Vendor\Repositories\Dashboard;

use Modules\Vendor\Entities\Vendor;
use Hash;
use DB;

class VendorRepository
{

    function __construct(Vendor $vendor)
    {
        $this->vendor   = $vendor;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $vendors = $this->vendor->active()->orderBy($order, $sort)->get();
        return $vendors;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $vendors = $this->vendor->orderBy($order, $sort)->get();
        return $vendors;
    }

    public function findById($id)
    {
        $vendor = $this->vendor->withDeleted()->find($id);
        return $vendor;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $vendor = $this->vendor->create([
                'delivery_time'       => $request->delivery_time,
                'vendor_status_id'    => $request->vendor_status_id,
                'image'               => path_without_domain($request->image),
                'status'              => $request->status ? 1 : 0,
            ]);

            $vendor->sellers()->sync($request->sellers);
            $vendor->sections()->sync($request->section_id);
            $vendor->areas()->sync($request->area_id);
            $this->vendorImages($vendor, $request);

            $this->translateTable($vendor, $request);

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

        $vendor = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($vendor) : null;

        try {

            $vendor->update([
                'delivery_time'     => $request->delivery_time,
                'vendor_status_id'  => $request->vendor_status_id,
                'status'            => $request->status ? 1 : 0,
                'image'             => $request->image ? path_without_domain($request->image) : $vendor->image,
            ]);

            $vendor->sellers()->sync($request->sellers);
            $vendor->sections()->sync($request->section_id);
            $vendor->areas()->sync($request->area_id);
            $this->vendorImages($vendor, $request);

            $this->translateTable($vendor, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function vendorImages($model, $request)
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

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function translateTable($model, $request)
    {
        foreach ($request['title'] as $locale => $value) {
            $model->translateOrNew($locale)->title           = $value;
            $model->translateOrNew($locale)->slug            = slugfy($value);
            $model->translateOrNew($locale)->description     = $request['description'][$locale];
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
        $query = $this->vendor->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->whereHas('translations', function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('description', 'like', '%' . $request->input('search.value') . '%');
                        $query->orWhere('title', 'like', '%' . $request->input('search.value') . '%');
                        $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');
                    });
                });
            });
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search Vendors by Created Dates
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
