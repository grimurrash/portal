<?php

namespace App\Dto\OrganizationProject;

use App\Enums\OrganizationProject\OrganizationProjectStatusEnum;
use Carbon\Carbon;

readonly class OrganizationProjectListItemDto
{
    public function __construct(
        public int                           $id,
        public int                           $number,
        public OrganizationProjectStatusEnum $status,
        public string                        $name,
        public string                        $description,
        public Carbon                        $startDate,
        public Carbon                        $endDate,
        public array                         $dates,
        public int                           $responsibleUserId,
        public string                        $responsibleUserName,
        public int                           $curatorUserId,
        public string                        $curatorUserName,
        public int                           $organizerUserId,
        public string                        $organizerUserName,
    )
    {
    }
}
