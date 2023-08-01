<?php

namespace App\Repositories;

use App\Contracts\User\UserRepositoryInterface;
use App\Dto\User\CreateUserDto;
use App\Models\User;
use Carbon\Carbon;

class UserRepository implements UserRepositoryInterface
{
    public function create(CreateUserDto $dto): void
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => bcrypt($dto->password),
            'email_verified_at' => $dto->isEmailVerified ? Carbon::now() : null,
        ]);

        $user->assignRole($dto->role->value);
    }
}
