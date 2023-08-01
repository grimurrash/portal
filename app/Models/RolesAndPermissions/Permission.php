<?php

namespace App\Models\RolesAndPermissions;

use App\Enums\PermissionEnum;
use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    protected $casts = [
        'name' => PermissionEnum::class
    ];
}
