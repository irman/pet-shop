<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Http\Resources\PromotionCollection;
use App\Models\Post;
use App\Services\Query\PostQuery;
use App\Services\Query\PromotionQuery;
use Fouladgar\EloquentBuilder\Exceptions\FilterException;
use Illuminate\Http\Request;
use Throwable;

class MainController extends Controller
{
    /**
     * @throws Throwable
     * @throws FilterException
     */
    public function promotions(Request $request): PromotionCollection
    {
        $data = (new PromotionQuery())->listFromRequest($request);
        return new PromotionCollection($data);
    }

    /**
     * @throws Throwable
     * @throws FilterException
     */
    public function posts(Request $request): PostCollection
    {
        $data = (new PostQuery())->listFromRequest($request);
        return new PostCollection($data);
    }

    public function postIndex(Request $request, Post $post): PostResource
    {
        return new PostResource($post);
    }
}
