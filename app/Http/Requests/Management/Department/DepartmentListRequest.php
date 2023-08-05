<?php

namespace App\Http\Requests\Management\Department;

use App\Enums\SortOrderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search' => ['sometimes', 'string', 'nullable'],
            'parent_department_id' => ['sometimes', 'int', 'nullable'],
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
