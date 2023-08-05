<?php

namespace App\Enums\RoleAndPermission;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case EMPLOYEE_MCPS = 'employee';
    case EXTERNAL_EMPLOYEE = 'external_employee';

    public function isMain(): bool
    {
        return match ($this) {
            self::ADMIN => true,
            default => false,
        };
    }
}
