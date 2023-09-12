<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Http\Requests\Admin\UserDestroyRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Http\Resources\APIResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Models\User;
use App\Services\Auth\Jwt;
use App\Services\Query\UserQuery;
use Fouladgar\EloquentBuilder\Exceptions\FilterException;
use Illuminate\Http\Request;
use Str;
use Throwable;

class AdminController extends Controller
{
    use Authenticatable;

    /**
     * @throws FilterException
     * @throws Throwable
     */
    public function listing(Request $request): UserResourceCollection
    {
        $data = (new UserQuery())->listFromRequest($request);
        return new UserResourceCollection($data);
    }

    public function store(AdminStoreRequest $request): UserResource
    {
        $user = new User($request->validated());
        $user->uuid = Str::orderedUuid()->toString();
        $user->is_marketing = $request->get('marketing', false);
        $user->is_admin = 1;
        $user->save();

        # Log this user in and get token
        $jwtToken = Jwt::login($user);
        $user->setAttribute('token', $jwtToken->unique_id);

        return (new UserResource($user))->setTrimInfo(true);
    }

    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $user->fill($request->validated());
        if ($request->has('marketing')) {
            $user->is_marketing = $request->get('marketing', false);
        }
        $user->save();

        return new UserResource($user);
    }

    public function destroy(UserDestroyRequest $request, User $user): APIResource
    {
        $user->delete();

        return new APIResource([]);
    }
}
