<?php

namespace Modules\Area\Repositories\Dashboard;

use Modules\Area\Entities\Area;
use DB;

class AreaRepository
{

    function __construct(Area $area)
    {
        $this->area   = $area;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $countrys = $this->country->orderBy($order, $sort)->get();
        return $countrys;
    }

    public function getAllByStateId($stateId)
    {
        $areas = $this->area->where('state_id', $stateId)->get();
        return $areas;
    }

    public function findById($id)
    {
        $area = $this->area->withDeleted()->find($id);
        return $area;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $area = $this->area->create([
                'state_id'     => $request->state_id,
                'status'       => $request->status ? 1 : 0,
            ]);

            $this->translateTable($area, $request);

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

        $area = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($area) : null;

        try {

            $area->update([
                'state_id'     => $request->state_id,
                'status'       => $request->status ? 1 : 0,
            ]);

            $this->translateTable($area, $request);

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

        $query = $this->area->with(['state', 'translations'])->where(function ($query) use ($request) {

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
        // Search Area by Created Dates
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
