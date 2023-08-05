<?php

namespace App\Http\Requests\Management\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeOptionsByDepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'department_id' => ['required', 'int']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
