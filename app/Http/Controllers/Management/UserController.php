<?php

namespace App\Http\Controllers\Management;

use App\Contracts\User\UserServiceInterface;
use App\Dto\User\CreateUserDto;
use App\Enums\RoleEnum;
use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\User\CreateUserRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceInterface $userService,
    )
    {
    }

    /**
     * @throws ForbiddenException
     */
    public function createUser(CreateUserRequest $request): JsonResponse
    {
        if (!config('app.is_enabled_register')) {
            throw new ForbiddenException('Регистрация недоступна');
        }

         $this->userService->createUser(new CreateUserDto(
            name: $request->get('name'),
            email: $request->get('email'),
            password: $request->get('password'),
            role: $request->enum('role', RoleEnum::class),
            isEmailVerified: $request->boolean('is_email_verified'),
        ));

        return response()->json();
    }
}
