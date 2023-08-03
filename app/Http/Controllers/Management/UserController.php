<?php

namespace App\Http\Controllers\Management;

use App\Contracts\User\UserServiceInterface;
use App\Dto\User\CreateUserDto;
use App\Dto\User\UserListFilterDto;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\User\CreateUserRequest;
use App\Http\Resources\PaginateResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceInterface $userService,
    )
    {
    }

    public function create(CreateUserRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);

        $this->userService->createUser(
            new CreateUserDto(
                name: $request->get('name'),
                email: $request->get('email'),
                password: $request->get('password'),
                role: $request->enum('role', RoleEnum::class),
                isEmailVerified: $request->boolean('is_email_verified'),
            )
        );

        return response()->json();
    }
    public function index(): JsonResponse
    {
        $this->authorize('view', User::class);
        $list = $this->userService->list(new UserListFilterDto(
            null,
            null,
            10,
            1,
            'id',
            true
        ));

        return response()->json(PaginateResource::make($list));
    }
}
