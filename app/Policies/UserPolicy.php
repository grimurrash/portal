<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::READ_USER);
    }

    public function view(User $user, $userId): bool
    {
        return $user->id === $userId || $user->hasPermission(PermissionEnum::READ_USER);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::CREATE_USER);
    }

    public function update(User $user, int $userId): bool
    {
        return $user->id === $userId || $user->hasPermission(PermissionEnum::UPDATE_USER);
    }

    public function delete(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::DELETE_USER);
    }
}
