<?php

namespace App\Enums\RoleAndPermission;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case EMPLOYEE_MCPS = 'employee';
    case EXTERNAL_EMPLOYEE = 'external_employee';
    case ORGANIZATION_PROJECT_ORGANIZER = 'organization_project_organizer';
    case ORGANIZATION_PROJECT_MODERATOR = 'organization_project_moderator';

    public function isMain(): bool
    {
        return match ($this) {
            self::EMPLOYEE_MCPS,
            self::EXTERNAL_EMPLOYEE=> false,
            default => true,
        };
    }
}
