<?php

namespace App\Repositories;

use App\Contracts\Employee\EmployeeRepositoryInterface;
use App\Dto\Employee\EmployeeListDto;
use App\Dto\Employee\EmployeeListFilterDto;
use App\Dto\Employee\ImportEmployeeDto;
use App\Models\Management\Employee;
use Illuminate\Support\Collection;

readonly class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * @return Collection<ImportEmployeeDto>
     */
    public function getImportList(): Collection
    {
        return Employee::with(['department'])
            ->get()
            ->map(fn(Employee $employee) => $employee->toImportDto());
    }

    /**
     * @param array<ImportEmployeeDto> $createEmployees
     * @return void
     */
    public function massCreate(array $createEmployees): void
    {
        Employee::query()->insert(array_map(fn(ImportEmployeeDto $dto) => $dto->toArray(), $createEmployees));
    }

    public function update(ImportEmployeeDto $dto): void
    {
        Employee::where('export_number', $dto->exportNumber)
            ->update($dto->toArray());
    }

    public function list(EmployeeListFilterDto $filter): EmployeeListDto
    {
        $list = Employee::query()
            ->with(['department'])
            ->searchFilter($filter->search)
            ->departmentIdFilter($filter->departmentId)
            ->ageFromFilter($filter->ageFrom)
            ->ageToFilter($filter->ageTo)
            ->isFoundersRepresentativeFilter($filter->isFoundersRepresentative)
            ->educationLevelFilter($filter->educationLevel)
            ->orderBy($filter->sortColumn, $filter->sortOrder->value)
            ->paginate(perPage: $filter->perPage, page: $filter->page);

        return new EmployeeListDto(
            items: $list->collect()->map(fn(Employee $item) => $item->toListItemDto())->toArray(),
            totalCount: $list->total(),
        );
    }

    public function optionsByDepartment(int $departmentId): array
    {
        return Employee::departmentIdFilter($departmentId)
            ->get()
            ->map(fn(Employee $employee) => $employee->toOptionItemDto())
            ->toArray();
    }
}
