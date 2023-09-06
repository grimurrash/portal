<?php

namespace App\Http\Requests\Activity\OrganizationProject;

use App\Enums\OrganizationProject\OrganizationProjectStatusEnum;
use App\Enums\SortOrderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetOrganizationProjectListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search' => ['sometimes', 'string', 'nullable'],
            'start_date' => ['sometimes', 'date', 'nullable'],
            'end_date' => ['sometimes', 'date', 'nullable'],
            'status' => ['sometimes', 'nullable', Rule::enum(OrganizationProjectStatusEnum::class)],
            'page' => ['sometimes', 'int'],
            'per_page' => ['sometimes', 'int'],
            'sort_column' => ['sometimes', 'string'],
            'sort_order' => ['sometimes', Rule::enum(SortOrderEnum::class), 'nullable']
        ];
    }
}
