<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->errors(),
                'message' => $exception->getMessage(),
            ], 422);
        });

        $this->renderable(function (AuthenticationException $exception) {
            return response()->json([
                'message' => 'Не аутентифицированный',
            ], 401);
        });

        $this->renderable(function (Throwable $exception) {
            $message = $exception->getMessage();

            if ($exception->getCode() === 0) {
                if (app()->environment('production')) {
                    $message = 'Упс, похоже, что-то пошло не так';
                } else {
                    dd($exception);
                }
            }
            return response()->json(['message' => $message], $exception->getCode() === 0 ? 500 : $exception->getCode());
        });
    }
}
