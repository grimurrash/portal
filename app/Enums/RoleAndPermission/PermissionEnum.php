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

    case READ_ORGANIZATION_PROJECT = 'read_organizationProject';
    case CREATE_ORGANIZATION_PROJECT = 'create_organizationProject';
    case UPDATE_ORGANIZATION_PROJECT = 'update_organizationProject';
    case CONTROL_ORGANIZATION_PROJECT  = 'control_organizationProject';

    case READ_WORD_CLOUD = 'read_WordCloud';
    case CREATE_WORD_CLOUD = 'create_WordCloud';

    public function getSubject(): string
    {
        return substr(strstr($this->value, '_'),1);
    }

    public function getAction(): string
    {
        return strstr($this->value, '_', true);
    }
}
