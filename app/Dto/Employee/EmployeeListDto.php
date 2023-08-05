<?php

namespace App\Dto\Employee;

use App\Dto\PaginateDto;
use App\Http\Resources\Management\Employee\EmployeeListItemResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/** @property array<EmployeeListItemDto> $items */
readonly class EmployeeListDto extends PaginateDto
{
    public function getItems(): AnonymousResourceCollection
    {
        return EmployeeListItemResource::collection($this->items);
    }
}
