<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;

/**
 * @mixin Order
 */
class OrderResource extends APIResource
{
    /**
     * @param Request $request
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'order_status_uuid' => $this->order_status_uuid,
            'delivery_fee' => $this->delivery_fee,
            'amount' => $this->amount,
            'products' => [],
            'address' => [],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'shipped_at' => $this->shipped_at,
        ];
    }
}
