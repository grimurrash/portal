<?php

namespace App\Contracts\Department;

use App\Dto\Department\DepartmentListDto;
use App\Dto\Department\DepartmentListFilterDto;
use App\Dto\Department\UpdateDepartmentDto;

interface DepartmentServiceInterface
{
    public function update(UpdateDepartmentDto $dto): void;

    public function list(DepartmentListFilterDto $dto): DepartmentListDto;

    public function parentDepartmentOptions(): array;
    public function allDepartmentOptions(): array;

    public function delete(int $id): void;
}
