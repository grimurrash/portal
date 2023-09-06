<?php

namespace App\Services\Activity;

use App\Contracts\OrganizationProject\OrganizationProjectRepositoryInterface;
use App\Contracts\OrganizationProject\OrganizationProjectServiceInterface;
use App\Dto\OrganizationProject\CreateOrganizationProjectDto;
use App\Dto\OrganizationProject\OrganizationProjectListDto;
use App\Dto\OrganizationProject\OrganizationProjectListFilterDto;
use App\Exceptions\BadRequestException;

readonly class OrganizationProjectService implements OrganizationProjectServiceInterface
{
    public function __construct(
        private OrganizationProjectRepositoryInterface $organizationProjectRepository,
    )
    {
    }

    /**
     * @throws BadRequestException
     */
    public function create(CreateOrganizationProjectDto $dto): void
    {
        try {
            $this->organizationProjectRepository->create($dto);
        } catch (\Throwable $exception) {
            throw new BadRequestException('Ошибка создания проекта', previous: $exception);
        }
    }

    public function moderationList(OrganizationProjectListFilterDto $filter): OrganizationProjectListDto
    {
        return $this->organizationProjectRepository->moderationList($filter);
    }

    public function generalList(OrganizationProjectListFilterDto $filter): OrganizationProjectListDto
    {
        return $this->organizationProjectRepository->generalList($filter);
    }

    public function list(OrganizationProjectListFilterDto $filter): OrganizationProjectListDto
    {
        return $this->organizationProjectRepository->list($filter);
    }
}
