<?php

namespace App\Http\Requests\Management\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'role' => ['required', 'string'],
            'permission' => ['required', 'string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
