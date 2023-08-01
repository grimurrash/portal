<?php

namespace Tests\Feature\Management;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateUser(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->post(route('management.users.create'), [
            'email' => 'test@email.com',
            'name' => 'test',
            'password' => 'test',
            'role' => RoleEnum::EMPLOYEE_MCPS->value,
        ]);
        $response->assertOk();
    }
}
