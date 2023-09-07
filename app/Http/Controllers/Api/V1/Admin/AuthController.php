<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\APIResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request): APIResource
    {
        $credential = $request->only(['email', 'password']);
        $credential['is_admin'] = 1;

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
