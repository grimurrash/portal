<?php

namespace App\Dto\OrganizationProject;

use App\Dto\PaginateDto;
use App\Http\Resources\Activity\OrganizationProject\OrganizationProjectListItemResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/** @property array<OrganizationProjectListItemDto> $items */
readonly class OrganizationProjectListDto extends PaginateDto
{
    public function getItems(): AnonymousResourceCollection
    {
        return OrganizationProjectListItemResource::collection($this->items);
    }
}
