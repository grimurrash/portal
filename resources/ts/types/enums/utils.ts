import { RoleEnum, RoleEnumEn } from '@/types/enums/role.enum'
import { PermissionEnum, PermissionEnumEn } from '@/types/enums/permission.enum'

type EnumDictionary<T, U> = {
  [K in keyof T]: U;
};

export const toRoleEnum = (role: RoleEnum | undefined): RoleEnumEn | undefined => {
    return role ? Object.keys(RoleEnum)[Object.values(RoleEnum).indexOf(role)] : role
}

export const toRoleEnumRu = (role: RoleEnum): RoleEnum => {
  const roles: EnumDictionary<string, RoleEnum> = {
    'admin': RoleEnum.admin,
    'employee': RoleEnum.employee,
    'external_employee': RoleEnum.external_employee
  }

  return roles[role]
}

export const toPermissionEnum = (permission: PermissionEnum | undefined): PermissionEnumEn | undefined => {
  return permission ? Object.keys(PermissionEnum)[Object.values(PermissionEnum).indexOf(permission)] : permission
}

export const toPermissionEnumRu = (permission: string): PermissionEnum => {
  const permissions: EnumDictionary<string, PermissionEnum> = {
    [PermissionEnumEn.manage_all]: PermissionEnum.manage_all,
    [PermissionEnumEn.read_department]: PermissionEnum.read_department,
    [PermissionEnumEn.create_user]: PermissionEnum.create_user,
  }
  return permissions[permission]
}
