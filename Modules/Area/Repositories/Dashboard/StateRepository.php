<?php

namespace Modules\Area\Repositories\Dashboard;

use Modules\Area\Entities\State;
use DB;

class StateRepository
{
    public $state;

    function __construct(State $state)
    {
        $this->state   = $state;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $states = $this->state->orderBy($order, $sort)->get();
        return $states;
    }

    public function getAllByCityId($cityId)
    {
        $states = $this->state->where('city_id', $cityId)->get();
        return $states;
    }

    public function findById($id)
    {
        $state = $this->state->withDeleted()->find($id);
        return $state;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $state = $this->state->create([
                'city_id'      => $request->city_id,
                'status'       => $request->status ? 1 : 0,
            ]);

            $this->translateTable($state, $request);

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

        $state = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($state) : null;

        try {

            $state->update([
                'city_id'      => $request->city_id,
                'status'       => $request->status ? 1 : 0,
            ]);

            $this->translateTable($state, $request);

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

            $state = $this->findById($id);

            if ($state->trashed()) :
                $state->forceDelete();
            else :
                $state->delete();
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
        $query = $this->state->with(['city', 'translations'])->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhereHas('translations', function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');
                });
            });
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search State by Created Dates
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
