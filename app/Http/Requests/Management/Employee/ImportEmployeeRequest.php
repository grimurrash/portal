<?php

namespace App\Http\Requests\Management\Employee;

use Illuminate\Foundation\Http\FormRequest;

class ImportEmployeeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'max:50000', 'mimes:xlsx,xls,xlsm'],
            'sheet_name' => ['sometimes', 'string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
