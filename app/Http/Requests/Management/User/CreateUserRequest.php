<?php

namespace App\Http\Requests\Management\User;

use App\Enums\RoleAndPermission\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:4'],
            'role' => ['required', Rule::enum(RoleEnum::class)],
            'is_email_verified' => ['sometimes', 'bool']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
