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
     * @param RoleEnum $mainRole
     * @param array<PermissionEnum> $permissions
     */
    public function __construct(
        public int      $id,
        public string   $name,
        public string   $email,
        public RoleEnum $mainRole,
        public array    $permissions,
    )
    {
    }
}
