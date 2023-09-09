<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->user()->is_admin ?? false) {
            /** @var User $user */
            $user = $this->route('user');
            return !$user->is_admin;
        }
        return false;
    }
}
