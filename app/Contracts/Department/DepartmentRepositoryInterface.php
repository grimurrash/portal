<?php

namespace App\Contracts\Department;

use App\Dto\Department\DepartmentListDto;
use App\Dto\Department\DepartmentListFilterDto;
use App\Dto\Department\UpdateDepartmentDto;
use App\Dto\OptionItemDto;
use Illuminate\Support\Collection;

interface DepartmentRepositoryInterface
{
    /**
     * @return Collection<OptionItemDto>
     */
    public function getImportList(): Collection;

    public function create(string $name): OptionItemDto;

    public function update(UpdateDepartmentDto $dto): void;

    public function list(DepartmentListFilterDto $filter): DepartmentListDto;

    public function delete(int $id): void;

    public function parentDepartmentOptions(): array;
    public function allDepartmentOptions(): array;
}
