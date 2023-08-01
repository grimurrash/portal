<?php

namespace App\Models\RolesAndPermissions;

use App\Enums\RoleEnum;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    protected $casts = [
        'name' => RoleEnum::class
    ];
}
