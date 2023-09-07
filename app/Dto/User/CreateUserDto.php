<?php

namespace App\Dto\User;

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Enums\RoleAndPermission\RoleEnum;

readonly class CreateUserDto
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param array<RoleEnum> $roles
     * @param array<PermissionEnum> $permissions
     * @param bool $isEmailVerified
     */
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public array  $roles,
        public array  $permissions,
        public bool   $isEmailVerified,
    )
    {
    }
}
