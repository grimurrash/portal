<?php

namespace App\Contracts\OrganizationProject;

use App\Dto\OrganizationProject\CreateOrganizationProjectDto;
use App\Dto\OrganizationProject\OrganizationProjectListDto;
use App\Dto\OrganizationProject\OrganizationProjectListFilterDto;

interface OrganizationProjectRepositoryInterface
{
    public function create(CreateOrganizationProjectDto $dto): void;
    public function moderationList(OrganizationProjectListFilterDto $filter): OrganizationProjectListDto;
    public function generalList(OrganizationProjectListFilterDto $filter): OrganizationProjectListDto;
    public function list(OrganizationProjectListFilterDto $filter): OrganizationProjectListDto;
}
