<?php

namespace App\Dto\User;

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Enums\RoleAndPermission\RoleEnum;
use App\Enums\SortOrderEnum;

readonly class UserListFilterDto
{
    public function __construct(
        public string|null          $search,
        public RoleEnum|null        $role,
        public PermissionEnum|null  $permission,
        public int                  $perPage = 15,
        public int                  $page = 1,
        public string               $sortColumn = 'id',
        public SortOrderEnum        $sortOrder = SortOrderEnum::DESC
    )
    {
    }
}
