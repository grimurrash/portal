<?php

namespace App\Contracts\User;

use App\Dto\User\CreateUserDto;
use App\Dto\User\ShowUserDto;
use App\Dto\User\UpdateUserDto;
use App\Dto\User\UserListDto;
use App\Dto\User\UserListFilterDto;

interface UserServiceInterface
{
    public function createUser(CreateUserDto $dto): void;
    public function list(UserListFilterDto $dto): UserListDto;
    public function show(int $id): ShowUserDto;
    public function update(UpdateUserDto $dto): void;
    public function delete(int $id): void;
}
