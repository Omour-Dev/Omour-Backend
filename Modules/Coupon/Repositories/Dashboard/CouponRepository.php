<?php

namespace Modules\Coupon\Repositories\Dashboard;

use Modules\Coupon\Entities\Coupon;
use Hash;
use DB;

class CouponRepository
{

    function __construct(Coupon $coupon)
    {
        $this->coupon   = $coupon;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $coupons = $this->coupon->active()->orderBy($order, $sort)->get();
        return $coupons;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $coupons = $this->coupon->orderBy($order, $sort)->get();
        return $coupons;
    }

    public function findById($id)
    {
        $coupon = $this->coupon->find($id);
        return $coupon;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

          $coupon = $this->coupon->create([
              'code'   => $request->code,
              'fixed'   => $request->fixed ? $request->fixed : 0.000,
              'percentage'   => $request->percentage ? $request->percentage : 0,
              'start'   => $request->start,
              'end'   => $request->end,
              'status'   => $request->status ? 1 : 0,
          ]);

          DB::commit();
          return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function update($request,$id)
    {
        DB::beginTransaction();

        $coupon = $this->findById($id);

        try {

            $coupon->update([
                'code'   => $request->code,
                'fixed'   => $request->fixed ? $request->fixed : 0.000,
                'percentage'   => $request->percentage ? $request->percentage : 0,
                'start'   => $request->start,
                'end'   => $request->end,
                'status'   => $request->status ? 1 : 0,
            ]);


            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }


    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()):
              $model->forceDelete();
            else:
              $model->delete();
            endif;

            DB::commit();
            return true;

        }catch(\Exception $e){
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

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->coupon->where(function($query) use($request){
                      $query->where('id'     , 'like' , '%'. $request->input('search.value') .'%');
                      $query->orWhere('code' , 'like' , '%'. $request->input('search.value') .'%');
                });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        // Search Coupons by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();

        return $query;
    }

}
