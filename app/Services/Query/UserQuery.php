<?php

namespace App\Services\Query;

use App\Models\User;
use App\Services\Query\Query;
use Illuminate\Database\Eloquent\Builder;

class UserQuery extends Query
{
    protected array $allowedSortColumn = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'address',
        'phone_number',
        'is_marketing',
    ];

    public function __construct()
    {
        $baseQuery = User::query()->where('is_admin', 0);
        parent::__construct($baseQuery);
    }
}
