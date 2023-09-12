<?php

namespace App\Services\Query;

use EloquentBuilder;
use Fouladgar\EloquentBuilder\Exceptions\FilterException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Throwable;

class Query
{
    protected Builder $baseQuery;
    protected array $allowedSortColumn = [];

    public function __construct(Builder $baseQuery)
    {
        $this->baseQuery = $baseQuery;
    }

    protected function baseQuery(): Builder
    {
        return $this->baseQuery;
    }

    /**
     * @throws FilterException
     * @throws Throwable
     */
    public function list(
        array $filters,
        int   $page,
        int   $limit,
        string|null $sortColumn = null,
        bool  $sortDesc = true,
    ): LengthAwarePaginator
    {
        $limit = min($limit, 50);
        if (!in_array($sortColumn, $this->allowedSortColumn)) {
            $sortColumn = null;
        }
        $sortDirection = $sortDesc ? 'desc' : 'asc';

        $query = $this->baseQuery();
        if ($sortColumn) {
            $query->orderBy($sortColumn, $sortDirection);
        }

        return EloquentBuilder::model($query)
            ->filters($filters)
            ->thenApply()
            ->paginate(
                perPage: $limit,
                page: $page,
            );
    }

    /**
     * @throws FilterException
     * @throws Throwable
     */
    public function listFromRequest(Request $request): LengthAwarePaginator
    {
        $filters = $request->except(['page', 'limit', 'sortBy', 'desc']);
        $page = (int)$request->get('page', 1);
        $limit = (int)$request->get('limit', 10);
        $sortBy = $request->get('sortBy');
        $desc = $request->boolean('desc');

        return $this->list($filters, $page, $limit, $sortBy, $desc);
    }
}
