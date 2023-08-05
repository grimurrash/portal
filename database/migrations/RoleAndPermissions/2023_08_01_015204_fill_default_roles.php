<?php

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Enums\RoleAndPermission\RoleEnum;
use App\Models\RolesAndPermissions\Permission;
use App\Models\RolesAndPermissions\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $permission = Permission::create([
            'name' => PermissionEnum::MANAGE_ALL->value,
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => PermissionEnum::READ_DEPARTMENT->value,
            'guard_name' => 'api',
        ]);
        Role::create([
            'name' => RoleEnum::EMPLOYEE_MCPS->value,
            'guard_name' => 'api',
        ]);
        Role::create([
            'name' => RoleEnum::EXTERNAL_EMPLOYEE->value,
            'guard_name' => 'api',
        ]);
        $role = Role::create([
            'name' => RoleEnum::ADMIN->value,
            'guard_name' => 'api',
        ]);
        DB::table('role_has_permissions')->insert([
            'role_id' => $role->id,
            'permission_id' => $permission->id
        ]);
    }

    public function down(): void
    {
        DB::table('model_has_roles')->whereNotNull('role_id')->delete();
        DB::table('role_has_permissions')->whereNotNull('role_id')->delete();
        DB::table('permissions')->whereNotNull('id')->delete();
        DB::table('roles')->whereNotNull('id')->delete();
    }
};
