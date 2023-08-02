<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;


    public function view(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::READ_EMPLOYEE);
    }

    public function export(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::EXPORT_EMPLOYEE);
    }

    public function import(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::IMPORT_EMPLOYEE);
    }
}
