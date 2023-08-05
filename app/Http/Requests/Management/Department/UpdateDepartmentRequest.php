<?php

namespace App\Http\Requests\Management\Department;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'parent_department_id' => ['sometimes', 'int', 'nullable'],
            'head_employee_id' => ['sometimes', 'int', 'nullable']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
