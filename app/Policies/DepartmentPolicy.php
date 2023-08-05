<?php

namespace App\Policies;

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    public function view(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::READ_DEPARTMENT);
    }

    public function update(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::UPDATE_DEPARTMENT);
    }

    public function delete(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::DELETE_DEPARTMENT);
    }

    public function export(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::EXPORT_DEPARTMENT);
    }
}
