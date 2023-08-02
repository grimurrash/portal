<?php

namespace App\Dto\Department;

use App\Dto\PaginateDto;
use App\Http\Resources\Management\Department\DepartmentListItemResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/** @property array<DepartmentListItemDto> $items */
readonly class DepartmentListDto extends PaginateDto
{
    public function getItems(): AnonymousResourceCollection
    {
        return DepartmentListItemResource::collection($this->items);
    }
}
