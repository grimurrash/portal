import { RoleEnum } from '@/types/enums/role.enum'
import { PermissionEnum } from '@/types/enums/permission.enum'

declare interface UserListItemModel {
  id: number
  name: string
  email: string
  role: RoleEnum
  permission: PermissionEnum
}
declare interface UserListResponse extends PaginateListResponse {
  items: Array<UserListItemModel>
}
declare interface ShowUserResponse {
  id: number
  name: string
  email: string
  role: RoleEnum
  permission: PermissionEnum
}
