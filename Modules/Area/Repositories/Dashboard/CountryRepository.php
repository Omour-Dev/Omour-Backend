<?php

namespace Modules\Area\Repositories\Dashboard;

use Modules\Area\Entities\Country;
use DB;

class CountryRepository
{

    public $country;
    function __construct(Country $country)
    {
        $this->country   = $country;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $countrys = $this->country->orderBy($order, $sort)->get();
        return $countrys;
    }

    public function findById($id)
    {
        $country = $this->country->withDeleted()->find($id);
        return $country;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $country = $this->country->create([
                'status'   => $request->status ? 1 : 0,
            ]);

            $this->translateTable($country, $request);

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

        $country = $this->findById($id);

        $restore = $request->restore ? $this->restoreSoftDelte($country) : null;

        try {

            $country->update([
                'status'   => $request->status ? 1 : 0,
            ]);

            $this->translateTable($country, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($country)
    {
        $country->restore();
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

            $country = $this->findById($id);

            if ($country->trashed()) :
                $country->forceDelete();
            else :
                $country->delete();
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

        $query = $this->country->with(['translations'])
            ->where(function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    return $query->where('id', 'like', '%' . $request->input('search.value') . '%')
                        ->orWhereHas('translations', function ($query) use ($request) {
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
        // Search Countries by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }
        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0') {
            $query->unactive();
        }

        return $query;
    }
}
