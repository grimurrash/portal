<?php

namespace App\Dto\Department;

readonly class UpdateDepartmentDto
{
    public function __construct(
        public int      $id,
        public string   $name,
        public int|null $parentDepartmentId,
        public int|null $headEmployeeId,
    )
    {
    }
}
