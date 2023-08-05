<?php

namespace App\Http\Requests\Management\Employee;

use App\Enums\Employee\GenderEnum;
use App\Enums\SortOrderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search' => ['sometimes', 'string', 'nullable'],
            'department_id' => ['sometimes', 'int', 'nullable'],
            'gender' => ['sometimes',  'nullable', Rule::enum(GenderEnum::class)],
            'is_founders_representative' => ['sometimes', 'bool', 'nullable'],
            'age_from' => ['sometimes', 'int', 'nullable'],
            'age_to' => ['sometimes', 'int', 'nullable'],
            'education_level' => ['sometimes', 'string', 'nullable'],
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
