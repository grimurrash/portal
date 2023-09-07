import { RoleEnum } from '@/types/enums/role.enum'
import { PermissionEnum } from '@/types/enums/permission.enum'

declare interface UserListFilterDto {
  role: RoleEnum | undefined
  permission: PermissionEnum | undefined
}

declare interface UserListRequestDto {
  filters: UserListFilterDto,
  options: TableOptions
}

