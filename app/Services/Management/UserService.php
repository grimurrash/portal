<?php

namespace App\Services\Management;

use App\Contracts\User\UserRepositoryInterface;
use App\Contracts\User\UserServiceInterface;
use App\Dto\User\CreateUserDto;
use App\Dto\User\UserListDto;
use App\Dto\User\UserListFilterDto;
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
    public function list(UserListFilterDto $dto): UserListDto
    {
        return $this->userRepository->list($dto);
    }
}
