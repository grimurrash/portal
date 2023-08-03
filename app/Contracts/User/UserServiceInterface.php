<?php

namespace App\Contracts\User;

use App\Dto\User\CreateUserDto;
use App\Dto\User\UserListDto;
use App\Dto\User\UserListFilterDto;

interface UserServiceInterface
{
    public function createUser(CreateUserDto $dto): void;

    public function list(UserListFilterDto $dto): UserListDto;
}
