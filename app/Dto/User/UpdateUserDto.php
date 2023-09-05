<?php

namespace App\Dto\User;

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Enums\RoleAndPermission\RoleEnum;

readonly class UpdateUserDto
{
    public function __construct(
        public int              $id,
        public string           $name,
        public string           $email,
        public RoleEnum         $mainRole,
        public PermissionEnum   $permissions,
    )
    {
    }
}
