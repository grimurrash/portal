<?php

namespace App\Dto\User;

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Enums\RoleAndPermission\RoleEnum;

readonly class ShowUserDto
{
    /**
     * @param int $id
     * @param string $name
     * @param string $email
     * @param RoleEnum|null $role
     * @param array<PermissionEnum>|null $permissions
     */
    public function __construct(
        public int           $id,
        public string        $name,
        public string        $email,
        public RoleEnum|null $role,
        public array|null    $permissions,
    )
    {
    }
}
