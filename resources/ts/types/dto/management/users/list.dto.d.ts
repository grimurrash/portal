import { PermissionEnumEn } from '@/types/enums/permission.enum'
import { RoleEnumEn } from '@/types/enums/role.enum'

declare interface UserListFilterDto {
  role: RoleEnumEn | undefined
  permission: PermissionEnumEn | undefined
}
declare interface UserListRequestDto {
  filters: UserListFilterDto,
  options: TableOptions
}

