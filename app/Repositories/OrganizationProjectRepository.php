<?php

namespace App\Repositories;

use App\Contracts\OrganizationProject\OrganizationProjectRepositoryInterface;
use App\Dto\OrganizationProject\CreateOrganizationProjectDto;
use App\Dto\OrganizationProject\OrganizationProjectListDto;
use App\Dto\OrganizationProject\OrganizationProjectListFilterDto;
use App\Enums\OrganizationProject\OrganizationProjectStatusEnum;
use App\Models\Activity\OrganizationProject;

readonly class OrganizationProjectRepository implements OrganizationProjectRepositoryInterface
{
    public function create(CreateOrganizationProjectDto $dto): void
    {
        OrganizationProject::create($dto->toArray());
    }

    public function moderationList(OrganizationProjectListFilterDto $filter): OrganizationProjectListDto
    {
        $list = OrganizationProject::query()
            ->with(['organizerUser', 'curatorUser', 'responsibleUser'])
            ->statusFilter(OrganizationProjectStatusEnum::MODERATION)
            ->searchFilter($filter->search)
            ->startDateFilter($filter->startDate)
            ->endDateFilter($filter->endDate)
            ->orderBy($filter->sortColumn, $filter->sortOrder->value)
            ->paginate(perPage: $filter->perPage, page: $filter->page);

        return new OrganizationProjectListDto(
            items: $list->collect()->map(fn(OrganizationProject $item) => $item->toListItemDto())->toArray(),
            totalCount: $list->total(),
        );
    }

    public function generalList(OrganizationProjectListFilterDto $filter): OrganizationProjectListDto
    {
        $list = OrganizationProject::query()
            ->with(['organizerUser', 'curatorUser', 'responsibleUser'])
            ->searchFilter($filter->search)
            ->statusFilter($filter->status)
            ->startDateFilter($filter->startDate)
            ->endDateFilter($filter->endDate)
            ->orderBy($filter->sortColumn, $filter->sortOrder->value)
            ->paginate(perPage: $filter->perPage, page: $filter->page);

        return new OrganizationProjectListDto(
            items: $list->collect()->map(fn(OrganizationProject $item) => $item->toListItemDto())->toArray(),
            totalCount: $list->total(),
        );
    }

    public function list(OrganizationProjectListFilterDto $filter): OrganizationProjectListDto
    {
        $list = OrganizationProject::query()
            ->with(['organizerUser', 'curatorUser', 'responsibleUser', 'moderatorUser'])
            ->where(function ($q) use ($filter) {
                $q->where('responsible_user_id', $filter->userId)
                    ->orWhere('curator_user_id', $filter->userId)
                    ->orWhere('moderator_user_id', $filter->userId)
                    ->orWhere('organizer_user_id', $filter->userId);
            })
            ->searchFilter($filter->search)
            ->statusFilter($filter->status)
            ->startDateFilter($filter->startDate)
            ->endDateFilter($filter->endDate)
            ->orderBy($filter->sortColumn, $filter->sortOrder->value)
            ->paginate(perPage: $filter->perPage, page: $filter->page);

        return new OrganizationProjectListDto(
            items: $list->collect()->map(fn(OrganizationProject $item) => $item->toListItemDto())->toArray(),
            totalCount: $list->total(),
        );
    }
}
