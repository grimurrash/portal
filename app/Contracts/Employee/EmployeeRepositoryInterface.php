<?php

namespace App\Contracts\Employee;

use App\Dto\Employee\EmployeeListDto;
use App\Dto\Employee\EmployeeListFilterDto;
use App\Dto\Employee\ImportEmployeeDto;
use Illuminate\Support\Collection;

interface EmployeeRepositoryInterface
{
    /**
     * @return Collection<ImportEmployeeDto>
     */
    public function getImportList(): Collection;

    /**
     * @param array<ImportEmployeeDto> $createEmployees
     * @return void
     */
    public function massCreate(array $createEmployees): void;

    public function update(ImportEmployeeDto $dto): void;

    public function list(EmployeeListFilterDto $filter): EmployeeListDto;

    public function optionsByDepartment(int $departmentId): array;
}
