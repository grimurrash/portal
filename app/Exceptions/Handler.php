<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (ValidationException $exception) {
            return response()->json([
                'errors' => array_map(function ($errors) {
                    return $errors[0] ?? null;
                }, $exception->errors()),
                'message' => $exception->getMessage(),
            ], 422);
        });

        $this->renderable(function (AuthenticationException $exception) {
            return response()->json([
                'message' => 'Не аутентифицированный',
            ], 401);
        });
        $this->renderable(function (AccessDeniedHttpException $exception) {
            return response()->json([
                'message' => 'Недостаточно прав',
            ], 403);
        });

        $this->renderable(function (Throwable $exception) {
            $message = $exception->getMessage();

            $code = $exception->getCode();
            if ($code=== 0 || $code > 500 || strlen($code) > 3) {
                $code = 500;
                if (app()->environment('production')) {
                    $message = 'Упс, похоже, что-то пошло не так';
                } else {
                    dd($exception);
                }
            }
            return response()->json(
                ['message' => $message],
                $code
            );
        });
    }
}
