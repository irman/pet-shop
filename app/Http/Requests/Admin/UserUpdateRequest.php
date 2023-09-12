<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var User $user */
        $user = $this->route('user');

        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignoreModel($user),
            ],
            'password' => 'required|confirmed|min:8',
            'avatar' => '',
            'address' => 'required',
            'phone_number' => 'required',
            'marketing' => 'nullable|boolean',
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('Admin cannot be edited');
    }
}
