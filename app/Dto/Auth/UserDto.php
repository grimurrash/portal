<?php

namespace App\Dto\Auth;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;

readonly class UserDto
{
    /**
     * @param int $id
     * @param string $name
     * @param string $email
     * @param RoleEnum $maneRole
     * @param array<PermissionEnum> $permissions
     */
    public function __construct(
        public int      $id,
        public string   $name,
        public string   $email,
        public RoleEnum $maneRole,
        public array    $permissions,
    )
    {
    }
}
