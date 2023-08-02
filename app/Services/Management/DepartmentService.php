<?php

namespace App\Services\Management;

use App\Contracts\Department\DepartmentRepositoryInterface;
use App\Contracts\Department\DepartmentServiceInterface;
use App\Dto\Department\DepartmentListDto;
use App\Dto\Department\DepartmentListFilterDto;
use App\Dto\Department\UpdateDepartmentDto;
use App\Exceptions\BadRequestException;
use Throwable;

readonly class DepartmentService implements DepartmentServiceInterface
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository,
    )
    {
    }

    /**
     * @throws BadRequestException
     */
    public function update(UpdateDepartmentDto $dto): void
    {
        try {
            $this->departmentRepository->update($dto);
        } catch (Throwable $exception) {
            throw new BadRequestException('Ошибка обновления отдела', previous: $exception);
        }
    }

    /**
     * @throws BadRequestException
     */
    public function delete(int $id): void
    {
        try {
            $this->departmentRepository->delete($id);
        } catch (Throwable $exception) {
            throw new BadRequestException('Ошибка удаления отдела', previous: $exception);
        }
    }

    public function list(DepartmentListFilterDto $dto): DepartmentListDto
    {
        return $this->departmentRepository->list($dto);
    }
}
