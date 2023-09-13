<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    public function update(OrderUpdateRequest $request, Order $order): OrderResource
    {
        $order->order_status_uuid = $request->validated('order_status_uuid');
        $order->save();
        return new OrderResource($order);
    }

}
