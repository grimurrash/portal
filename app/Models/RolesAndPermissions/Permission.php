<?php

namespace App\Models\RolesAndPermissions;

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission as BasePermission;

/**
 * App\Models\RolesAndPermissions\Permission
 *
 * @property int $id
 * @property PermissionEnum $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, BasePermission> $permissions
 * @property-read Collection<int, Role> $roles
 * @property-read Collection<int, User> $users
 * @method static Builder|Permission newModelQuery()
 * @method static Builder|Permission newQuery()
 * @method static Builder|Permission permission($permissions)
 * @method static Builder|Permission query()
 * @method static Builder|Permission role($roles, $guard = null)
 * @mixin Eloquent
 */
class Permission extends BasePermission
{
    protected $casts = [
        'name' => PermissionEnum::class
    ];
}
