<?php

namespace Tests;

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Enums\RoleAndPermission\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function authUser(User|null $user = null, RoleEnum $role = RoleEnum::EMPLOYEE_MCPS, PermissionEnum|null $permission = null): User
    {
        if (is_null($user)) {
            $user = User::factory()->create();
        }
        Sanctum::actingAs($user);
        $user->assignRole($role->value);
        if (!is_null($permission)) {
            $user->givePermissionTo($permission->value);
        }

        return $user;
    }
}
