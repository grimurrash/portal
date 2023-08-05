<?php

namespace App\Dto\Department;

readonly class DepartmentListItemDto
{
    public function __construct(
        public int         $id,
        public string      $name,
        public int|null    $parentDepartmentId,
        public string|null $parentDepartmentName,
        public int|null    $headEmployeeId,
        public string|null $headEmployeeFullName,
        public int         $employeeCount,
    )
    {
    }
}
