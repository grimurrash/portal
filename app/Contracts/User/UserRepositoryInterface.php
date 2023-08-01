<?php

namespace App\Contracts\User;

use App\Dto\User\CreateUserDto;

interface UserRepositoryInterface
{
    public function create(CreateUserDto $dto): void;
}
