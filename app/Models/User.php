<?php

namespace App\Models;

use App\Dto\Auth\UserDto;
use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

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
        /** @var Collection<RoleEnum> $roles */
        $roles = $this->roles->pluck('name')
            ->map(fn($item) => RoleEnum::from($item));
        /** @var RoleEnum $mainRole */
        $mainRole = $roles->first();
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
}
