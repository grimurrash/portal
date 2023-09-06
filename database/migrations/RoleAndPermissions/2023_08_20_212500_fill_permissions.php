<?php

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Models\RolesAndPermissions\Permission;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Permission::create([
            'name' => PermissionEnum::READ_ORGANIZATION_PROJECT->value,
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => PermissionEnum::CREATE_ORGANIZATION_PROJECT->value,
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => PermissionEnum::UPDATE_ORGANIZATION_PROJECT->value,
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => PermissionEnum::CONTROL_ORGANIZATION_PROJECT->value,
            'guard_name' => 'api',
        ]);
    }

    public function down(): void
    {
        Permission::query()
            ->whereIn('name', [
                PermissionEnum::READ_ORGANIZATION_PROJECT->value,
                PermissionEnum::UPDATE_ORGANIZATION_PROJECT->value,
                PermissionEnum::CONTROL_ORGANIZATION_PROJECT->value,
                PermissionEnum::CREATE_ORGANIZATION_PROJECT->value,
            ])
            ->delete();
    }
};
