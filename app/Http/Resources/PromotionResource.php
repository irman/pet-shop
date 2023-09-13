<?php

namespace App\Http\Resources;

use App\Models\Promotion;
use Illuminate\Http\Request;

/**
 * @mixin Promotion
 */
class PromotionResource extends APIResource
{
    /**
     * @param Request $request
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'content' => $this->content,
            'metadata' => $this->metadata,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
