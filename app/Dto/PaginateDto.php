<?php

namespace App\Dto;

readonly class PaginateDto
{
    public function __construct(
        public array $items,
        public int   $totalCount,
    )
    {
    }
}
