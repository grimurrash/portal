<?php

namespace App\Http\Resources\Activity\OrganizationProject;

use App\Dto\OrganizationProject\OrganizationProjectListItemDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin OrganizationProjectListItemDto */
class OrganizationProjectListItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status->value,
            'start_date' => $this->startDate->toDateString(),
            'end_date' => $this->endDate->toDateString(),
            'dates' => $this->dates,
            'responsible_user_id' => $this->responsibleUserId,
            'responsible_user_name' => $this->responsibleUserName,
            'curator_user_id' => $this->curatorUserId,
            'curator_user_name' => $this->curatorUserName,
            'organizer_user_id' => $this->organizerUserId,
            'organizer_user_name' => $this->organizerUserName,
        ];
    }
}
