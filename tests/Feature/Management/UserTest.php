<?php

namespace Tests\Feature\Management;

use App\Enums\RoleAndPermission\PermissionEnum;
use App\Enums\RoleAndPermission\RoleEnum;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateUser(): void
    {
        $this->authUser(permission: PermissionEnum::CREATE_USER);

        $response = $this->post(route('management.users.create'), [
            'email' => 'test@email.com',
            'name' => 'test',
            'password' => 'test',
            'role' => RoleEnum::EMPLOYEE_MCPS->value,
        ]);
        $response->assertOk();
    }
}
