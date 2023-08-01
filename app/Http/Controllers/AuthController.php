<?php

namespace App\Http\Controllers;

use App\Contracts\Auth\AuthServiceInterface;
use App\Dto\Auth\LoginDto;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\AuthUserResource;
use App\Http\Resources\Auth\LoggedUserResource;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthServiceInterface $authService,
    )
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $authData = $this->authService->login(new LoginDto(
            email: $request->get('email'),
            password: $request->get('password'),
            rememberMe: $request->boolean('remember_me')
        ));

        return response()->json(LoggedUserResource::make($authData));
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();
        return response()->json();
    }

    public function user(): JsonResponse
    {
        $user = $this->authService->user();
        return response()->json(AuthUserResource::make($user));
    }
}
