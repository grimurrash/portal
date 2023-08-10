<?php

namespace App\Repositories;

use App\Contracts\User\UserRepositoryInterface;
use App\Dto\Auth\LoggedUserDto;
use App\Dto\Auth\LoginDto;
use App\Dto\User\CreateUserDto;
use App\Dto\User\UserListDto;
use App\Dto\User\UserListFilterDto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

readonly class UserRepository implements UserRepositoryInterface
{
    public function create(CreateUserDto $dto): void
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' =>  bcrypt($dto->password),
            'email_verified_at' => $dto->isEmailVerified ? Carbon::now() : null,
        ]);

        $user->assignRole($dto->role->value);
    }

    public function login(LoginDto $dto): LoggedUserDto
    {
        $user = User::where('email', $dto->email)->first();

        if (is_null($user) || !Hash::check($dto->password, $user->password)) {
            throw ValidationException::withMessages(['password' => 'Неверный логин или пароль']);
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
    public function list(UserListFilterDto $filter): UserListDto
    {
        $list = User::query()
            ->orderBy($filter->sortColumn, $filter->sortOrder->value)
            ->paginate(perPage: $filter->perPage, page: $filter->page);

        return new UserListDto(
            items: $list->collect()->map(fn(User $item) => $item->toListItemDto())->toArray(),
            totalCount: $list->total()
        );
    }
}
