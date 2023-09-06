<?php

namespace App\Http\Requests\Management\User;

use App\Enums\SortOrderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search' => ['sometimes', 'string', 'nullable'],
            'page' => ['sometimes', 'int'],
            'per_page' => ['sometimes', 'int'],
            'sort_column' => ['sometimes', 'string'],
            'sort_order' => ['sometimes', Rule::enum(SortOrderEnum::class), 'nullable']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
