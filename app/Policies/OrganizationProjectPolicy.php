<?php

namespace App\Policies;

use App\Enums\OrganizationProject\OrganizationProjectStatusEnum;
use App\Enums\RoleAndPermission\PermissionEnum;
use App\Models\Activity\OrganizationProject;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationProjectPolicy
{
    use HandlesAuthorization;

    public function viewModerate(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::UPDATE_ORGANIZATION_PROJECT);
    }

    public function viewList(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::READ_ORGANIZATION_PROJECT);
    }

    public function viewGeneralList(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::CONTROL_ORGANIZATION_PROJECT);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::CREATE_ORGANIZATION_PROJECT);
    }

    public function postForModeration(User $user, OrganizationProject $organizationProject): bool
    {
        if ($organizationProject->status !== OrganizationProjectStatusEnum::CREATE) {
            return false;
        }

        return $user->id === $organizationProject->organizer_user_id
            && $user->hasPermission(PermissionEnum::CREATE_ORGANIZATION_PROJECT);
    }

    public function moderate(User $user, OrganizationProject $organizationProject): bool
    {
        return $user->hasPermission(PermissionEnum::UPDATE_ORGANIZATION_PROJECT);
    }
}
