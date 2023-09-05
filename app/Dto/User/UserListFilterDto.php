<?php

namespace App\Dto\User;

use App\Enums\SortOrderEnum;

readonly class UserListFilterDto
{
    public function __construct(
        public string|null $search,
        public string|null $role,
        public string|null $permission,
        public int         $perPage = 15,
        public int         $page = 1,
        public string      $sortColumn = 'id',
        public SortOrderEnum $sortOrder = SortOrderEnum::DESC
    )
    {
    }
}
