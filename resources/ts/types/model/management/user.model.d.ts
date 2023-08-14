import { RoleEnum, RoleEnumEn } from '@/types/enums/role.enum'
import { PermissionEnum, PermissionEnumEn } from '@/types/enums/permission.enum'

declare interface UserListItemModel {
  id: number
  name: string
  email: string
  roles: Array<RoleEnum>
  permissions: Array<PermissionEnum>
}
declare interface UserListResponse extends PaginateListResponse {
  items: Array<UserListItemModel>
}
declare interface ShowUserResponse {
  id: number
  name: string
  email: string
  roles: Array<RoleEnumEn>
  permissions: Array<PermissionEnumEn>
}