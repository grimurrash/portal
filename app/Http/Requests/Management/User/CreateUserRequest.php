<?php

namespace App\Http\Requests\Management\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:4'],
            'roles' => ['sometimes', 'array'],
            'permissions' => ['sometimes', 'array'],
            'is_email_verified' => ['sometimes', 'bool']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
