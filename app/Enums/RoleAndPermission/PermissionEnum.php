<?php

namespace App\Enums\RoleAndPermission;

enum PermissionEnum: string
{
    //Actions: 'create' | 'read' | 'update' | 'delete' | 'manage'
    case MANAGE_ALL = 'manage_all';
    case READ_DEPARTMENT = 'read_department';
    case UPDATE_DEPARTMENT = 'update_department';
    case DELETE_DEPARTMENT = 'delete_department';
    case EXPORT_DEPARTMENT = 'export_department';

    case READ_USER = 'read_user';
    case CREATE_USER = 'create_user';
    case UPDATE_USER = 'update_user';
    case DELETE_USER = 'delete_user';

    case READ_EMPLOYEE = 'read_employee';
    case EXPORT_EMPLOYEE = 'export_employee';
    case IMPORT_EMPLOYEE = 'import_employee';

    public function getSubject(): string
    {
        return explode('_', $this->value)[1];
    }

    public function getAction(): string
    {
        return explode('_', $this->value)[0];
    }
}
