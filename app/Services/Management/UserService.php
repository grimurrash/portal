<?php

namespace App\Services\Management;

use App\Contracts\User\UserRepositoryInterface;
use App\Contracts\User\UserServiceInterface;
use App\Dto\User\CreateUserDto;
use App\Dto\User\ShowUserDto;
use App\Dto\User\UpdateUserDto;
use App\Dto\User\UserListDto;
use App\Dto\User\UserListFilterDto;
use App\Exceptions\BadRequestException;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();
        try {
            $this->userRepository->create($dto);
            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();
            throw new BadRequestException('Ошибка создания пользователя', previous: $exception);
        }
    }

    /**
     * @throws BadRequestException
     */
    public function list(UserListFilterDto $filter): UserListDto
    {
        try {
            return $this->userRepository->list($filter);
        } catch (Throwable $exception) {
            throw new BadRequestException('Ошибка при выводе списка пользователей', previous: $exception);
        }
    }

    /**
     * @throws BadRequestException
     */
    public function show(int $id): ShowUserDto
    {
        try {
            return $this->userRepository->show($id);
        } catch (Throwable $exception) {
            throw new BadRequestException('Ошибка при выводе пользователя', previous: $exception);
        }
    }

    /**
     * @throws BadRequestException
     */
    public function update(UpdateUserDto $dto): void
    {
        try {
            $this->userRepository->update($dto);
        } catch (Throwable $exception) {
            throw new BadRequestException('Ошибка обновления пользователя', previous: $exception);
        }
    }

    /**
     * @throws BadRequestException
     */
    public function delete(int $id): void
    {
        try {
            $this->userRepository->delete($id);
        } catch (Throwable $exception) {
            throw new BadRequestException('Ошибка удаления пользователя', previous: $exception);
        }
    }

}
