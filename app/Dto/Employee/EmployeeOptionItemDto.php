<?php

namespace App\Dto\Employee;

readonly class EmployeeOptionItemDto
{
    public function __construct(
        public int    $id,
        public string $name,
    )
    {
    }
}
