<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class UserDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var User $user */
        $user = auth()->user();
        return !$user->is_admin;
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('Admin cannot be deleted');
    }
}
