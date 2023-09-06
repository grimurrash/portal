<?php

namespace App\Repositories;

use App\Contracts\Department\DepartmentRepositoryInterface;
use App\Dto\Department\DepartmentListDto;
use App\Dto\Department\DepartmentListFilterDto;
use App\Dto\Department\UpdateDepartmentDto;
use App\Dto\OptionItemDto;
use App\Models\Management\Department;
use Illuminate\Support\Collection;

readonly class DepartmentRepository implements DepartmentRepositoryInterface
{
    /**
     * @return Collection<OptionItemDto>
     */
    public function getImportList(): Collection
    {
        return Department::get()
            ->map(fn(Department $department) => $department->toOptionItemDto());
    }

    public function create(string $name): OptionItemDto
    {
        $department = Department::where('name', $name)->first();

        if (is_null($department)) {
            $department = Department::create(['name' => $name]);
        }

        return $department->toOptionItemDto();
    }

    public function update(UpdateDepartmentDto $dto): void
    {
        Department::where('id', $dto->id)->update([
            'name' => $dto->name,
            'head_employee_id' => $dto->headEmployeeId,
            'parent_department_id' => $dto->parentDepartmentId
        ]);
    }

    public function list(DepartmentListFilterDto $filter): DepartmentListDto
    {
        $list = Department::query()
            ->with('headEmployee', 'parentDepartment')
            ->withCount('employees')
            ->searchFilter($filter->search)
            ->parentDepartmentIdFilter($filter->parentDepartmentId)
            ->orderBy($filter->sortColumn, $filter->sortOrder->value)
            ->paginate(perPage: $filter->perPage, page: $filter->page);

        return new DepartmentListDto(
            items: $list->collect()->map(fn(Department $item) => $item->toListItemDto())->toArray(),
            totalCount: $list->total(),
        );
    }

    public function delete(int $id): void
    {
        Department::where('id', $id)->delete();
    }

    public function parentDepartmentOptions(): array
    {
        return Department::whereHas('childrenDepartments')
            ->get()
            ->map(fn(Department $department) => $department->toOptionItemDto())
            ->toArray();
    }

    public function allDepartmentOptions(): array
    {
        return Department::get()
            ->map(fn(Department $department) => $department->toOptionItemDto())
            ->toArray();
    }
}
