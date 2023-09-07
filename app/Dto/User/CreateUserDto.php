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
     * @param array<RoleEnum>|null $roles
     * @param array<PermissionEnum>|null $permissions
     * @param bool $isEmailVerified
     */
    public function __construct(
        public string           $name,
        public string           $email,
        public string           $password,
        public array|null       $roles,
        public array|null       $permissions,
        public bool             $isEmailVerified,
    )
    {
    }
}
