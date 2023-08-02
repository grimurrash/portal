<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class BadRequestException extends Exception
{
    public function __construct(string $message = "", int $code = 400, ?Throwable $previous = null)
    {
        if (!is_null($previous) && !app()->isProduction()) {
            $message = $previous->getMessage();
        }
        
        parent::__construct($message, $code, $previous);
    }
}
