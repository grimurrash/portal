<?php

namespace App\Dto\User;

use App\Enums\RoleEnum;

readonly class UserListItemDto
{
    /**
     * @param int $id
     * @param string $name
     * @param string $email
     * @param array<RoleEnum> $roles
     */
    public function __construct(
        public int    $id,
        public string $name,
        public string    $email,
        public array $roles,
    )
    {
    }
}
