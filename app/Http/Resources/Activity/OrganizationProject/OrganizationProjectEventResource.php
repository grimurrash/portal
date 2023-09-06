<?php

namespace App\Http\Resources\Activity\OrganizationProject;

use App\Dto\OrganizationProject\OrganizationProjectEventDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationProjectEventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var OrganizationProjectEventDto $this */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start' => $this->startDate,
            'end' => $this->endDate,
            'url' => '',
            'allDay' => true,
            'extendedProps' => [
                'project_id' => $this->projectId,
                'project_name' => $this->projectName,
            ]
        ];
    }
}
