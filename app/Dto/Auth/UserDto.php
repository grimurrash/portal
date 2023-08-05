<?php

namespace App\Dto\Auth;

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Enums\RoleAndPermission\RoleEnum;

readonly class UserDto
{
    /**
     * @param int $id
     * @param string $name
     * @param string $email
     * @param RoleEnum|null $mainRole
     * @param array<PermissionEnum>|null $permissions
     */
    public function __construct(
        public int           $id,
        public string        $name,
        public string        $email,
        public RoleEnum|null $mainRole,
        public array|null    $permissions,
    )
    {
    }
}
