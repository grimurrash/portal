<?php

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Models\RolesAndPermissions\Permission;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Permission::create([
            'name' => PermissionEnum::READ_WORD_CLOUD->value,
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => PermissionEnum::CREATE_WORD_CLOUD->value,
            'guard_name' => 'api',
        ]);
    }

    public function down(): void
    {
        Permission::query()
            ->whereIn('name', [
                PermissionEnum::READ_WORD_CLOUD->value,
                PermissionEnum::CREATE_WORD_CLOUD->value
            ])
            ->delete();
    }
};
