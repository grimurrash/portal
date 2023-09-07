import { RoleEnum, RoleEnumEn } from '@/types/enums/role.enum'
import { PermissionEnum, PermissionEnumEn } from '@/types/enums/permission.enum'

declare interface UserListItemModel {
  id: number
  name: string
  email: string
  roles: Array<RoleEnum>
  permissions: Array<PermissionEnum>
}

declare interface UserOptionItemModel {
  id: number
  name: string
}

declare interface UserListResponse extends PaginateListResponse{
  items: Array<UserListItemModel>
  total_count: number
}
declare interface ShowUserResponse {
  id: number
  name: string
  email: string
  roles: Array<RoleEnumEn>
  permissions: Array<PermissionEnumEn>
}
