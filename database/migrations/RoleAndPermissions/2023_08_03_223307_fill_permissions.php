<?php

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Models\RolesAndPermissions\Permission;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Permission::create([
            'name' => PermissionEnum::UPDATE_DEPARTMENT->value,
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => PermissionEnum::DELETE_DEPARTMENT->value,
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => PermissionEnum::EXPORT_DEPARTMENT->value,
            'guard_name' => 'api',
        ]);

        Permission::create([
            'name' => PermissionEnum::READ_EMPLOYEE->value,
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => PermissionEnum::EXPORT_EMPLOYEE->value,
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => PermissionEnum::IMPORT_EMPLOYEE->value,
            'guard_name' => 'api',
        ]);

        Permission::create([
            'name' => PermissionEnum::READ_USER->value,
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => PermissionEnum::UPDATE_USER->value,
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => PermissionEnum::DELETE_USER->value,
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => PermissionEnum::CREATE_USER->value,
            'guard_name' => 'api',
        ]);
    }

    public function down(): void
    {
    }
};
