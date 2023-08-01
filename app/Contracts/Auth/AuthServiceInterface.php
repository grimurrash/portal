<?php

namespace App\Contracts\Auth;

use App\Dto\Auth\LoggedUserDto;
use App\Dto\Auth\LoginDto;
use App\Dto\Auth\UserDto;

interface AuthServiceInterface
{
    public function login(LoginDto $dto): LoggedUserDto;

    public function logout(): void;

    public function user(): UserDto;
}
