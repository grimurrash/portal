<?php

namespace App\Dto\Department;

readonly class DepartmentOptionItemDto
{
    public function __construct(
        public int    $id,
        public string $name,
    )
    {
    }
}
