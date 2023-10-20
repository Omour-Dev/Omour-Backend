<?php

namespace Modules\Order\ViewComposers\Dashboard;

use Modules\Order\Repositories\Dashboard\OrderRepository as Order;
use Illuminate\View\View;
use Cache;

class OrderComposer
{
    public function __construct(Order $order)
    {
        $this->orders             =  $order->completeOrders();
        $this->monthlyOrders      =  $order->monthlyOrders();
        $this->totalProfit        =  $order->totalProfit();
        $this->ordersType         =  $order->ordersType();
    }

    public function compose(View $view)
    {
        $view->with('monthlyOrders'   , $this->monthlyOrders);
        $view->with('totalProfit'     , $this->totalProfit);
        $view->with('completeOrders'  , $this->orders);
        $view->with('ordersType'      , $this->ordersType);
    }
}
