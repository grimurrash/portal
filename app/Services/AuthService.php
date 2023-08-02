<?php

namespace App\Services;

use App\Contracts\Auth\AuthServiceInterface;
use App\Contracts\User\UserRepositoryInterface;
use App\Dto\Auth\LoggedUserDto;
use App\Dto\Auth\LoginDto;
use App\Dto\Auth\UserDto;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

readonly class AuthService implements AuthServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

    public function login(LoginDto $dto): LoggedUserDto
    {
        return $this->userRepository->login($dto);
    }

    /**
     * @throws AuthenticationException
     */
    public function logout(): void
    {
        $user = Auth::user();
        if (is_null($user)) {
            throw new AuthenticationException();
        }
        $user->tokens()->delete();
    }

    /**
     * @throws AuthenticationException
     */
    public function user(): UserDto
    {
        $user = Auth::user();
        if (is_null($user)) {
            throw new AuthenticationException();
        }
        return $user->toDto();
    }
}
