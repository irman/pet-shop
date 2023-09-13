<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # Hardcoded statuses
        $statuses = [
            Order::DEFAULT_STATUS_UUID => 'open',
            '7e2323c9-0ccf-36ce-8e6d-e763603e820e' => 'canceled',
            'ecb2ec13-9d39-35d7-abc8-74ce580e0752' => 'shipped',
            '4940cec6-4f42-3c7b-941c-a5d52f76c11f' => 'paid',
            'd448e41e-59c3-3aed-812b-d18701c97179' => 'pending payment',
        ];

        foreach($statuses as $uuid => $title) {
            $status = new OrderStatus();
            $status->uuid = $uuid;
            $status->title = $title;
            $status->save();
        }
    }
}
