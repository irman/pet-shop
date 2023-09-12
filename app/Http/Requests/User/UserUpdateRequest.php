<?php

namespace App\Http\Requests\User;

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
        /** @var User $user */
        $user = auth()->user();
        return !$user->is_admin;
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('Admin cannot be edited');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        /** @var User $user */
        $user = auth()->user();

        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignoreModel($user)
            ],
            'password' => 'required|confirmed|min:8',
            'avatar' => '',
            'address' => 'required',
            'phone_number' => 'required',
            'marketing' => 'nullable|boolean',
        ];
    }
}