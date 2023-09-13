<?php

namespace Tests\Unit;

use App\Models\Order;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use DatabaseTransactions;

    public function test_order_update(): void
    {
        $this->loginAsAdmin();

        $order = Order::first();
        $response = $this->put(route('order.update', [$order->uuid]), [
            'order_status_uuid' => Order::DEFAULT_STATUS_UUID,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => 1,
            ]);
    }
}
