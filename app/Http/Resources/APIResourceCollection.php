<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class APIResourceCollection extends ResourceCollection
{
    /**
     * Customize the pagination information for the resource.
     *
     * @param Request $request
     * @param array<string, mixed> $paginated
     * @param array<string, mixed> $default
     * @return array<string, mixed>
     */
    public function paginationInformation(Request $request, array $paginated, array $default): array
    {
        return collect($paginated)->except(['data'])->toArray();
    }
}
