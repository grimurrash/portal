<?php

namespace App\Contracts\User;

use App\Dto\Auth\LoggedUserDto;
use App\Dto\Auth\LoginDto;
use App\Dto\User\CreateUserDto;
use App\Dto\User\UserListDto;
use App\Dto\User\UserListFilterDto;

interface UserRepositoryInterface
{
    public function create(CreateUserDto $dto): void;

    public function login(LoginDto $dto): LoggedUserDto;


    public function list(UserListFilterDto $filter): UserListDto;
}
