<?php

namespace Modules\Order\Repositories\Vendor;

use Modules\Order\Entities\OrderStatus;
use Modules\Order\Entities\Order;
use VendorFacade;
use Auth;
use DB;

class OrderRepository
{
    function __construct(Order $order,OrderStatus $status)
    {
        $this->order   = $order;
        $this->status   = $status;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $orders = $this->order->where('vendor_id',VendorFacade::id())->orderBy($order, $sort)->get();

        return $orders;
    }

    public function findById($id)
    {
        $order = $this->order->where('vendor_id',VendorFacade::id())->withDeleted()->find($id);

        return $order;
    }

    public function updateUnread($id)
    {
        $order = $this->findById($id);

        $order->update([
          'unread'  => true,
        ]);
    }

    public function update($request,$id)
    {
        $order = $this->findById($id);

        $order->update([
          'order_status_id'  => $request['status_id'],
        ]);

        if ($request['driver']) {
            $order->driver()->updateOrCreate([
                'driver_id'  => $request['driver'],
            ]);
        }

        return true;
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
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
        $query = $this->order->with(['orderStatus','user']);

        $query->where('vendor_id',VendorFacade::id());


        $query->where(function($query) use($request){
            $query->where('id' , 'like' , '%'. $request->input('search.value') .'%');
        });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();

        if (isset($request['req']['status_id']))
            $query->where('order_status_id' , $request['req']['status_id']);


        if (isset($request['req']['user_id']))
            $query->where('user_id' , $request['req']['user_id']);

        return $query;
    }

    public function statusOfOrder($type)
    {
        if ($type)
            $status = $this->status->successPayment()->first();

        if (!$type)
            $status = $this->status->failedPayment()->first();

        return $status;
    }

}
