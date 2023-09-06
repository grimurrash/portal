<?php

namespace App\Models\RolesAndPermissions;

use App\Enums\RoleAndPermission\RoleEnum;
use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role as BaseRole;

/**
 * App\Models\RolesAndPermissions\Role
 *
 * @property int $id
 * @property RoleEnum $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Permission> $permissions
 * @property-read Collection<int, User> $users
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role permission($permissions)
 * @method static Builder|Role query()
 * @mixin Eloquent
 */
class Role extends BaseRole
{
    protected $casts = [
        'name' => RoleEnum::class
    ];

    protected $guarded = ['id'];
}
