<?php

namespace App\Contracts\User;

use App\Dto\User\CreateUserDto;

interface UserServiceInterface
{
    public function createUser(CreateUserDto $dto): void;
}
