<?php

namespace Modules\Order\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Order\Http\Requests\Vendor\OrderRequest;
use Modules\Order\Transformers\Vendor\OrderResource;
use Modules\Order\Repositories\Vendor\OrderRepository as Order;
use Modules\Order\Repositories\Dashboard\OrderStatusRepository as Status;
use Modules\Order\Notifications\Api\ResponseOrderNotification;
use Notification;
use Modules\User\Repositories\Dashboard\DriverRepository as Driver;

class OrderController extends Controller
{
    function __construct(Order $order,Status $status,Driver $driver)
    {
        $this->status = $status;
        $this->driver = $driver;
        $this->order = $order;
    }

    public function create()
    {
        return view('order::vendor.orders.create');
    }

    public function store(Request $request)
    {
        try {
            $create = $this->order->create($request);

            if ($create) {
                return Response()->json([true , __('apps::vendor.messages.created')]);
            }

            return Response()->json([false  , __('apps::vendor.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function index()
    {
        return view('order::vendor.orders.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->order->QueryTable($request));

        $datatable['data'] = OrderResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function show($id)
    {
        $drivers = $this->driver->getAllDrivers();
        $order = $this->order->findById($id);
        $statuses = $this->status->getAll();
        return view('order::vendor.orders.show',compact('order','statuses','drivers'));
    }

    public function update(Request $request, $id)
    {
        try {

            $update = $this->order->update($request,$id);

            if ($update) {
                return Response()->json([true , __('apps::vendor.messages.updated')]);
            }

            return Response()->json([false  , __('apps::vendor.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->order->delete($id);

            if ($delete) {
                return Response()->json([true , __('apps::vendor.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::vendor.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->order->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::vendor.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::vendor.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
