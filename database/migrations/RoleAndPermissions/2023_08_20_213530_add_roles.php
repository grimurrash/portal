<?php

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Enums\RoleAndPermission\RoleEnum;
use App\Models\RolesAndPermissions\Role;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        $role = Role::create([
            'name' => RoleEnum::ORGANIZATION_PROJECT_ORGANIZER->value,
            'guard_name' => 'api',
        ]);
        $role->forgetCachedPermissions();
        $role->givePermissionTo([PermissionEnum::READ_ORGANIZATION_PROJECT->value, PermissionEnum::CREATE_ORGANIZATION_PROJECT->value]);

        $role = Role::create([
            'name' => RoleEnum::ORGANIZATION_PROJECT_MODERATOR->value,
            'guard_name' => 'api',
        ]);
        $role->forgetCachedPermissions();
        $role->givePermissionTo([PermissionEnum::READ_ORGANIZATION_PROJECT->value, PermissionEnum::UPDATE_ORGANIZATION_PROJECT->value]);

        $role = Role::query()->where('name', RoleEnum::EMPLOYEE_MCPS->value)->first();
        $role->forgetCachedPermissions();
        $role->givePermissionTo([PermissionEnum::READ_ORGANIZATION_PROJECT->value]);
    }

    public function down(): void
    {
        Role::query()
            ->whereIn('name', [
                RoleEnum::ORGANIZATION_PROJECT_ORGANIZER->value,
                RoleEnum::ORGANIZATION_PROJECT_MODERATOR->value,
            ])
            ->delete();
    }
};
