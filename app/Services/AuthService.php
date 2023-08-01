<?php

namespace App\Services;

use App\Contracts\Auth\AuthServiceInterface;
use App\Dto\Auth\LoggedUserDto;
use App\Dto\Auth\LoginDto;
use App\Dto\Auth\UserDto;
use App\Exceptions\BadRequestException;
use App\Exceptions\ForbiddenException;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

readonly class AuthService implements AuthServiceInterface
{
    /**
     * @throws BadRequestException
     * @throws ForbiddenException
     */
    public function login(LoginDto $dto): LoggedUserDto
    {
        if (!Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password
        ])) {
            throw ValidationException::withMessages(['password' => 'Неверный логин или пароль']);
        }

        $user = Auth::user();


        if (is_null($user)) {
            throw ValidationException::withMessages(['email' => 'Неудачная попытка авторизации']);
        }

        if (is_null($user->email_verified_at)) {
            throw ValidationException::withMessages(['email' => 'Необходимо подтвердить почту']);
        }

        $expiresAt = $dto->rememberMe ? Carbon::now()->addWeek() : Carbon::now()->addDay();
        $token = $user->createToken('Personal Access Token', expiresAt: $expiresAt);

        return new LoggedUserDto(
            user: $user->toDto(),
            token: $token->plainTextToken,
            tokenExpiredAt: $expiresAt,
        );
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
