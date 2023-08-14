<?php

namespace App\Dto\User;

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Enums\RoleAndPermission\RoleEnum;

readonly class UpdateUserDto
{
    /**
     * @param int $id
     * @param string $name
     * @param string $email
     * @param array<RoleEnum>|null $roles
     * @param array<PermissionEnum>|null $permissions
     */
    public function __construct(
        public int              $id,
        public string           $name,
        public string           $email,
        public array|null    $roles,
        public array|null    $permissions,
    )
    {
    }
}