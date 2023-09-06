<?php

namespace App\Console\Commands;

use App\Contracts\User\UserServiceInterface;
use App\Dto\User\CreateUserDto;
use App\Enums\RoleAndPermission\RoleEnum;
use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    protected $signature = 'user:create';

    protected $description = 'Команда для создания пользователя (временно)';

    public function handle(UserServiceInterface $userService): void
    {
        $name = $this->ask('ФИО');
        $email = $this->ask('Email');
        $password = $this->ask('Пароль');
        $role = $this->choice('Роль', array_column(RoleEnum::cases(), 'value'));

        $userService->createUser(new CreateUserDto(
            name: $name,
            email: $email,
            password: $password,
            role: RoleEnum::from($role),
            isEmailVerified: true
        ));
    }
}
