<?php

namespace App\Services\Query;

use App\Models\Order;
use App\Models\User;

class OrderQuery extends Query
{
    protected array $allowedSortColumn = [];

    public function __construct(?User $user = null)
    {
        $baseQuery = Order::query();
        if ($user) {
            $baseQuery->where('orders.user_id', $user->id);
        }
        parent::__construct($baseQuery);
    }
}
