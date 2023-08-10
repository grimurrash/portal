<?php

namespace App\Dto\User;

use App\Enums\SortOrderEnum;

readonly class UserListFilterDto
{
    public function __construct(
        public string|null $search,
        public int         $perPage = 15,
        public int         $page = 1,
        public string      $sortColumn = 'id',
        public SortOrderEnum $sortOrder = SortOrderEnum::DESC
    )
    {
    }
}
