<?php

namespace App\Dto;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

readonly abstract class PaginateDto
{
    public function __construct(
        protected array $items,
        protected int   $totalCount,
    )
    {
    }

    abstract public function getItems(): AnonymousResourceCollection;

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }
}
