<?php

namespace App\Dto\User;

readonly class UserListFilterDto
{
    public function __construct(
        public string|null $search,
        public string|null $role,
        public int         $perPage,
        public int         $page,
        public string      $sortColumn,
        public bool        $sortDesc
    )
    {
    }
}
