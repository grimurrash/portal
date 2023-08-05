<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function testLogin(): void
    {
        $user = $this->authUser();
        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'user' => [
                'id',
                'email',
                'name',
                'role'
            ],
            'token',
            'abilities' => [
                '*' => [
                    'action',
                    'subject',
                ]
            ]
        ]);
    }

    public function testLogout(): void
    {
        $user = $this->authUser();
        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertOk();
        $token = $response->json('token');

        $response = $this->get(route('auth.logout'), ['Authorization' => 'Bearer ' . $token]);
        $response->assertOk();
    }

    public function testUser(): void
    {
        $user = $this->authUser();
        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk();
        $token = $response->json('token');

        $response = $this->get(route('auth.user'), ['Authorization' => 'Bearer ' . $token]);
        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'email',
            'name',
            'role'
        ]);
    }
}
