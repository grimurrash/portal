<?php

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Enums\RoleAndPermission\RoleEnum;
use App\Models\RolesAndPermissions\Permission;
use App\Models\RolesAndPermissions\Role;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        $readPermission = Permission::query()->where('name',PermissionEnum::READ_ORGANIZATION_PROJECT->value)->first();
        $createPermission = Permission::query()->where('name',PermissionEnum::CREATE_ORGANIZATION_PROJECT->value)->first();
        $updatePermission = Permission::query()->where('name',PermissionEnum::UPDATE_ORGANIZATION_PROJECT->value)->first();

        if (!isset($readPermission,$createPermission, $updatePermission)) {
            throw new RuntimeException('Not found permissions');
        }

        $role = Role::create([
            'name' => RoleEnum::ORGANIZATION_PROJECT_ORGANIZER->value,
            'guard_name' => 'api',
        ]);
        $role->permissions()->sync([$readPermission->id, $createPermission->id]);

        $role = Role::create([
            'name' => RoleEnum::ORGANIZATION_PROJECT_MODERATOR->value,
            'guard_name' => 'api',
        ]);
        $role->permissions()->sync([$readPermission->id, $updatePermission->id]);


        $role = Role::query()->where('name', RoleEnum::EMPLOYEE_MCPS->value)->first();
        $role->permissions()->sync([$readPermission->id]);
        $role->forgetCachedPermissions();
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
