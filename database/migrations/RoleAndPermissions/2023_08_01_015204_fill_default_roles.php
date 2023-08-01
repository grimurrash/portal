<?php

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\RolesAndPermissions\Permission;
use App\Models\RolesAndPermissions\Role;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Permission::create([
            'name' => PermissionEnum::MANAGE_ALL,
        ]);
        Permission::create([
            'name' => PermissionEnum::VIEW_DEPARTMENTS,
        ]);
        Role::create([
            'name' => RoleEnum::EMPLOYEE_MCPS,
        ]);
        Role::create([
            'name' => RoleEnum::EXTERNAL_EMPLOYEE,
        ]);
        $role = Role::create([
            'name' => RoleEnum::ADMIN,
        ]);
        $role->givePermissionTo(PermissionEnum::MANAGE_ALL->value);
    }

    public function down(): void
    {

    }
};
