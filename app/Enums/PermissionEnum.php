<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case MANAGE_ALL = 'manage_all';
    case VIEW_DEPARTMENTS = 'read_department';

    public function getSubject(): string
    {
        return explode('_', $this->value)[1];
    }

    public function getAction(): string
    {
        return explode('_', $this->value)[0];
    }
}
