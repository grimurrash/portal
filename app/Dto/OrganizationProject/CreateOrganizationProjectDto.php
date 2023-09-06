<?php

namespace App\Dto\OrganizationProject;

use App\Enums\OrganizationProject\OrganizationProjectStatusEnum;
use App\Models\User;
use Carbon\Carbon;

readonly class CreateOrganizationProjectDto
{
    public function __construct(
        public int    $number,
        public string $name,
        public string $description,
        public Carbon $startDate,
        public Carbon $endDate,
        public array  $dates,
        public string $metrics,
        public int    $plannedCoverage,
        public int    $actualCoverage,
        public int    $responsibleUserId,
        public int    $curatorUserId,
        public int    $organizerUserId,
    )
    {
    }

    public function toArray(): array
    {
        /** @var User $user */
        $user = auth()->user();
        return [
            'number' => $this->number,
            'name' => $this->name,
            'description' => $this->description,
            'status' => OrganizationProjectStatusEnum::CREATE,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'dates' => $this->dates,
            'metrics' => $this->metrics,
            'planned_coverage' => $this->plannedCoverage,
            'actual_coverage' => $this->actualCoverage,
            'responsible_user_id' => $this->responsibleUserId,
            'curator_user_id' => $this->curatorUserId,
            'organizer_user_id' => $this->organizerUserId,
            'change_logs' => [
                0 => (new OrganizationProjectChangeLogItemDto(
                    name: 'Создание',
                    userId: $user->id,
                    userName: $user->name,
                    datetime: Carbon::now()))->toArray()
            ],
        ];
    }
}
