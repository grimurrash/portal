<?php

namespace App\Services\Management;

use App\Contracts\User\UserRepositoryInterface;
use App\Contracts\User\UserServiceInterface;
use App\Dto\User\CreateUserDto;
use App\Exceptions\BadRequestException;
use Throwable;

readonly class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    )
    {
    }

    /**
     * @throws BadRequestException
     */
    public function createUser(CreateUserDto $dto): void
    {
        try {
            $this->userRepository->create($dto);
        } catch (Throwable $exception) {
            throw new BadRequestException('Ошибка создания пользователя', previous: $exception);
        }
    }
}
