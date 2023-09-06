<?php

namespace App\Http\Requests\Activity\OrganizationProject;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrganizationProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'number' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'dates' => ['required', 'array'],
            'dates.*' => ['array'],
            'dates.*.name' => ['string'],
            'dates.*.date' => ['date'],
            'metrics' => ['required'],
            'planned_coverage' => ['required', 'integer'],
            'actual_coverage' => ['required', 'integer'],
            'responsible_user_id' => ['required'],
            'curator_user_id' => ['required'],
        ];
    }
}
