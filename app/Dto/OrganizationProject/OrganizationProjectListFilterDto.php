<?php

namespace App\Dto\OrganizationProject;

use App\Enums\OrganizationProject\OrganizationProjectStatusEnum;
use App\Enums\SortOrderEnum;
use Carbon\Carbon;

readonly class OrganizationProjectListFilterDto
{
    public function __construct(
        public ?int                           $userId,
        public ?string                        $search,
        public ?Carbon                        $startDate,
        public ?Carbon                        $endDate,
        public ?OrganizationProjectStatusEnum $status,
        public int                            $perPage = 15,
        public int                            $page = 1,
        public string                         $sortColumn = 'id',
        public SortOrderEnum                  $sortOrder = SortOrderEnum::DESC
    )
    {
    }
}
