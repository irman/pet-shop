<?php

namespace App\Services\Query;

use App\Models\Post;

class PostQuery extends Query
{
    protected array $allowedSortColumn = [
        'title',
        'slug',
        'created_at',
    ];

    public function __construct()
    {
        $baseQuery = Post::query();
        parent::__construct($baseQuery);
    }
}
