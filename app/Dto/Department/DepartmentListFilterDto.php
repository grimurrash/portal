<?php

namespace App\Dto\Department;

readonly class DepartmentListFilterDto
{
    public function __construct(
        public string|null $search,
        public int|null    $parentDepartmentId,
        public int         $perPage,
        public int         $page,
        public string      $sortColumn,
        public bool        $sortDesc
    )
    {
    }
}
