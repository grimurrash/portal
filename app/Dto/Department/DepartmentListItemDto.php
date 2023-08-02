<?php

namespace App\Dto\Department;

readonly class DepartmentListItemDto
{
    public function __construct(
        public int    $id,
        public string $name,
        public int    $parentDepartmentId,
        public string $parentDepartmentName,
        public int    $headEmployeeId,
        public string $headEmployeeFullName,
        public int    $employeeCount,
    )
    {
    }
}
