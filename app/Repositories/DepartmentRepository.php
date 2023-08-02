<?php

namespace App\Repositories;

use App\Contracts\Department\DepartmentRepositoryInterface;
use App\Dto\Department\DepartmentListDto;
use App\Dto\Department\DepartmentListFilterDto;
use App\Dto\Department\UpdateDepartmentDto;
use App\Models\Department;

readonly class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function findOrCreate(string $name): int
    {
        $department = Department::where('name', $name)->first();

        if (is_null($department)) {
            $department = Department::create(['name' => $name]);
        }

        return $department->id;
    }

    public function update(UpdateDepartmentDto $dto): void
    {
        Department::where('id', $dto->id)->update([
            'name' => $dto->name,
            'head_employee_id' => $dto->headEmployeeId,
            'parent_department_id' => $dto->parentDepartmentId
        ]);
    }

    public function list(DepartmentListFilterDto $dto): DepartmentListDto
    {
        $query = Department::query();


        return new DepartmentListDto(
            items: [],
            totalCount: 0
        );
    }

    public function delete(int $id): void
    {
        Department::where('id', $id)->delete();
    }
}
