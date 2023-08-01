<?php

namespace App\Dto\Auth;

use Carbon\Carbon;

readonly class LoggedUserDto
{
    public function __construct(
        public UserDto $user,
        public string  $token,
        public Carbon  $tokenExpiredAt,
    )
    {
    }
}
