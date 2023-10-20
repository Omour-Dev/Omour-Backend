<?php

namespace Modules\Order\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Cart\Traits\CartTrait;
use Modules\Order\Repositories\Api\OrderRepository as Order;
use Modules\Order\Repositories\Dashboard\OrderStatusRepository as Status;
use Modules\Order\Transformers\Api\OrderResource;
use Modules\Order\Transformers\Dashboard\OrderStatusResource;
use Modules\Transaction\Services\PaymentService;

class OrderController extends ApiController
{
    use CartTrait;
    public $order;
    public $status;
    public $payment;
    public function __construct(Order $order, PaymentService $payment, Status $status)
    {
        $this->order = $order;
        $this->status = $status;
        $this->payment = $payment;
    }

    public function statuses(Request $request)
    {
        $statuses = $this->status->getAll();

        return OrderStatusResource::collection($statuses);
    }

    public function list(Request $request)
    {
        $orders = $this->order->getAllByUser();

        return OrderResource::collection($orders);
    }

    public function driverOrders(Request $request)
    {
        $orders = $this->order->driverOrders();

        return OrderResource::collection($orders);
    }

    public function driverUpdateOrders(Request $request)
    {
        $order = $this->order->driverUpdateOrders($request);

        return $this->response(new OrderResource($order));
    }

    public function add(Request $request)
    {
        if ($request['method'] == 'cash') {
            $order = $this->order->create($request);
            $this->clearCart($request);
        }

        return $this->response(new OrderResource($order));
    }

    public function rate(Request $request)
    {
        $this->order->rateOrder($request);

        $order = $this->order->findById($request['order_id']);

        return $this->response(new OrderResource($order));
    }
}
