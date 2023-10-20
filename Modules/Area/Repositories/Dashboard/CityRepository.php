<?php

namespace Modules\Area\Repositories\Dashboard;

use Modules\Area\Entities\City;
use DB;

class CityRepository
{

    function __construct(City $city)
    {
        $this->city   = $city;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $citys = $this->city->with(['states', 'translations'])->orderBy($order, $sort)->get();
        return $citys;
    }

    public function findById($id)
    {
        $city = $this->city->withDeleted()->find($id);
        return $city;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $city = $this->city->create([
                'country_id'   => $request->country_id,
                'status'       => $request->status ? 1 : 0,
            ]);

            $this->translateTable($city, $request);

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

        $city = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($city) : null;

        try {

            $city->update([
                'status'       => $request->status ? 1 : 0,
            ]);

            $this->translateTable($city, $request);

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
            $model->translateOrNew($locale)->slug            = slugfy($value);
        }

        $model->save();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $city = $this->findById($id);

            if ($city->trashed()) :
                $city->forceDelete();
            else :
                $city->delete();
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
        $query = $this->city->with(['country', 'translations'])->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->whereHas('translations', function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('title', 'like', '%' . $request->input('search.value') . '%');
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
        // Search Cities by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }
        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }
        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();

        return $query;
    }
}
