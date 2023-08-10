<?php

namespace App\Dto\User;


use App\Enums\RoleAndPermission\RoleEnum;

readonly class UserListItemDto
{
    /**
     * @param int $id
     * @param string $name
     * @param string $email
     * @param RoleEnum $role
     */
    public function __construct(
        public int    $id,
        public string $name,
        public string    $email,
        public RoleEnum $role,
    )
    {
    }
}
