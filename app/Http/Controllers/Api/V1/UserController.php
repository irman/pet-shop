<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserDestroyRequest;
use App\Http\Requests\User\UserForgotPasswordRequest;
use App\Http\Requests\User\UserResetPasswordRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\APIResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Auth\Jwt;
use App\Services\Query\OrderQuery;
use Fouladgar\EloquentBuilder\Exceptions\FilterException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Str;
use Throwable;

class UserController extends Controller
{
    use Authenticatable;

    public function index(): UserResource
    {
        $user = auth()->user();

        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request): UserResource
    {
        /** @var User $user */
        $user = auth()->user();
        $user->fill($request->validated());
        $user->save();

        return new UserResource($user);
    }

    public function destroy(UserDestroyRequest $request): APIResource
    {
        /** @var User $user */
        $user = auth()->user();
        $user->delete();

        return new APIResource([]);
    }

    public function store(UserStoreRequest $request): UserResource
    {
        $user = new User($request->validated());
        $user->uuid = Str::orderedUuid()->toString();
        $user->is_admin = 0;
        $user->save();

        # Log this user in and get token
        $jwtToken = Jwt::login($user);
        $user->setAttribute('token', $jwtToken->unique_id);

        return (new UserResource($user))->setTrimInfo(true);
    }

    public function forgotPassword(UserForgotPasswordRequest $request): APIResource
    {
        $user = User::whereEmail($request->get('email'))->first();

        if (!$user) {
            return (new APIResource([], 0))->setError('Invalid email')->setStatusCode(404);
        }

        $token = Password::createToken($user);

        return new APIResource([
            'reset_token' => $token,
        ]);
    }

    public function resetPassword(UserResetPasswordRequest $request): APIResource
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->password = $password;

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return new APIResource([
                'data' => [
                    'message' => 'Password has been successfully updated',
                ],
            ]);
        }

        return (new APIResource([]))->setError('Invalid or expired token');
    }

    /**
     * @throws FilterException
     * @throws Throwable
     */
    public function orders(Request $request): APIResource
    {
        $data = (new OrderQuery(auth()->user()))->listFromRequest($request);
        return new APIResource($data);
    }
}
