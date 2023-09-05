import { RoleEnum, RoleEnumEn } from '@/types/enums/role.enum'
import { PermissionEnum, PermissionEnumEn } from '@/types/enums/permission.enum'

type EnumDictionary<T, U> = {
  [K in keyof T]: U;
};

export const toRoleEnum = (role: RoleEnum | undefined): RoleEnumEn | undefined => {
  const roles: EnumDictionary<RoleEnumEn, RoleEnum> = {
    [RoleEnum.admin]: RoleEnumEn.admin,
    [RoleEnum.employee]: RoleEnumEn.employee,
    [RoleEnum.external_employee]: RoleEnumEn.external_employee
  }
    return role ? roles[role] : role
}

export const toRoleEnumRu = (role: string): RoleEnum => {
  const roles: EnumDictionary<string, RoleEnum> = {
    'admin': RoleEnum.admin,
    'employee': RoleEnum.employee,
    'external_employee': RoleEnum.external_employee
  }
  return roles[role]
}

export const toPermissionEnum = (permission: PermissionEnum | undefined): PermissionEnumEn | undefined => {
  const permissions: EnumDictionary<PermissionEnum, PermissionEnumEn> = {
    [PermissionEnum.manage_all]: PermissionEnumEn.manage_all,
    [PermissionEnum.read_department]: PermissionEnumEn.read_department,
  }
  return permission ? permissions[permission] : permission
}

export const toPermissionEnumRu = (permission: string): PermissionEnum => {
  const permissions: EnumDictionary<string, PermissionEnum> = {
    [PermissionEnumEn.manage_all]: PermissionEnum.manage_all,
    [PermissionEnumEn.read_department]: PermissionEnum.read_department,
  }
  return permissions[permission]
}
