<?php

namespace App\Dto\User;

use App\Enums\RoleEnum;

readonly class CreateUserDto
{
    public function __construct(
        public string   $name,
        public string   $email,
        public string   $password,
        public RoleEnum $role,
        public bool     $isEmailVerified,
    )
    {
    }
}
