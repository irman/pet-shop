<?php

namespace App\Services\Query;

use App\Models\Promotion;

class PromotionQuery extends Query
{
    protected array $allowedSortColumn = [
        'title',
        'created_at',
    ];

    public function __construct()
    {
        $baseQuery = Promotion::query();
        parent::__construct($baseQuery);
    }
}
