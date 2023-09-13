<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Request;

/**
 * @mixin Post
 */
class PostResource extends APIResource
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
            'slug' => $this->slug,
            'content' => $this->content,
            'metadata' => $this->metadata,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
