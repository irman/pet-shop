<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\APIResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin Controller
 */
trait Authenticatable
{
    public function login(Request $request): APIResource
    {
        $credential = $request->only(['email', 'password']);
        $credential = array_merge($credential, $this->additionalCredential ?? []);

        if (Auth::attempt($credential)) {
            return new APIResource([
                'token' => Auth::getToken(),
            ]);
        }

        return (new APIResource([]))->setError('Failed to authenticate user');
    }

    public function logout(): APIResource
    {
        Auth::logout();

        return new APIResource([]);
    }
}
