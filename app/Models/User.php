<?php

namespace App\Models;

use App\Dto\Auth\UserDto;
use App\Dto\OptionItemDto;
use App\Enums\RoleAndPermission\PermissionEnum;
use App\Enums\RoleAndPermission\RoleEnum;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read Collection<int, Permission> $permissions
 * @property-read Collection<int, Role> $roles
 * @property-read Collection<int, PersonalAccessToken> $tokens
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User onlyTrashed()
 * @method static Builder|User permission($permissions)
 * @method static Builder|User query()
 * @method static Builder|User role($roles, $guard = null)
 * @method static Builder|User withTrashed()
 * @method static Builder|User withoutTrashed()
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function toDto(): UserDto
    {
        $roles = $this->roles->pluck('name')
            ->map(fn($item) => RoleEnum::from($item));
        /** @var RoleEnum $mainRole */
        $mainRole = $roles->first();
        /** @var RoleEnum $role */
        foreach ($roles as $role) {
            if ($role->isMain()) {
                $mainRole = $role;
                break;
            }
        }
        return new UserDto(
            id: $this->id,
            name: $this->name,
            email: $this->email,
            mainRole: $mainRole,
            permissions: $this->getAllPermissions()->pluck('name')->map(fn($item) => PermissionEnum::from($item))->toArray()
        );
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function isSuperUser(): bool
    {
        return $this->hasRole(RoleEnum::ADMIN->value);
    }

    public function hasPermission(PermissionEnum $permission): bool
    {
        return $this->isSuperUser() || $this->hasPermissionTo($permission->value, 'api');
    }

    public function toOptionItemDto(): OptionItemDto
    {
        return new OptionItemDto(
            id: $this->id,
            label: $this->name,
        );
    }
}
