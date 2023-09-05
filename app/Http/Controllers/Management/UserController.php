<?php

namespace App\Http\Controllers\Management;

use App\Contracts\User\UserServiceInterface;
use App\Dto\User\CreateUserDto;
use App\Dto\User\UpdateUserDto;
use App\Dto\User\UserListFilterDto;
use App\Enums\RoleAndPermission\PermissionEnum;
use App\Enums\RoleAndPermission\RoleEnum;
use App\Enums\SortOrderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\User\CreateUserRequest;
use App\Http\Requests\Management\User\UpdateUserRequest;
use App\Http\Requests\Management\User\UserListRequest;
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
    public function index(UserListRequest $request): JsonResponse
    {
        $this->authorize('viewAny', User::class);
        $list = $this->userService->list(new UserListFilterDto(
            search: $request->get('search'),
            role: $request->enum('role', RoleEnum::class),
            permission: $request->enum('permission', PermissionEnum::class),
            perPage: $request->integer('per_page', 10),
            page: $request->integer('page', 1),
            sortColumn: $request->get('sort_column', 'id'),
            sortOrder: SortOrderEnum::from($request->get('sort_order', SortOrderEnum::DESC->value))
        ));
        return response()->json(PaginateResource::make($list));
    }
    public function show(int $id): JsonResponse
    {
        $this->authorize('view', [User::class, $id]);
        $user = $this->userService->show($id);
        return response()->json($user);
    }
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $this->authorize('update', [User::class, $id]);
        $this->userService->update(new UpdateUserDto(
            id: $id,
            name: $request->get('name'),
            email: $request->get('email'),
            mainRole: $request->enum('role', RoleEnum::class),
            permissions: $request->enum('permission', PermissionEnum::class),
        ));

        return response()->json();
    }
    public function destroy(int $id): JsonResponse
    {
        $this->authorize('delete', User::class);
        $this->userService->delete($id);
        return response()->json();
    }
}
