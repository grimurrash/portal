<?php

namespace App\Dto\Employee;

use App\Enums\Employee\GenderEnum;
use App\Enums\SortOrderEnum;

readonly class EmployeeListFilterDto
{
    public function __construct(
        public string|null     $search,
        public int|null        $departmentId,
        public GenderEnum|null $gender,
        public bool|null       $isFoundersRepresentative,
        public int|null        $ageFrom,
        public int|null        $ageTo,
        public string|null     $educationLevel,
        public int             $perPage = 15,
        public int             $page = 1,
        public string          $sortColumn = 'id',
        public SortOrderEnum $sortOrder = SortOrderEnum::DESC
    )
    {
    }
}
