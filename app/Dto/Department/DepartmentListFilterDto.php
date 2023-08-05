<?php

namespace App\Dto\Department;

use App\Enums\SortOrderEnum;

readonly class DepartmentListFilterDto
{
    public function __construct(
        public string|null  $search,
        public int|null     $parentDepartmentId,
        public int          $perPage = 15,
        public int          $page = 1,
        public string       $sortColumn = 'id',
        public SortOrderEnum $sortOrder = SortOrderEnum::DESC
    )
    {
    }
}
