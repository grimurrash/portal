import { RoleEnum } from '@/types/enums/role.enum'

declare interface UserListItemModel {
  id: number
  name: string
  email: string
  role: RoleEnum
}

declare interface UserOptionItemModel {
  id: number
  name: string
}

declare interface UserListResponse extends PaginateListResponse{
  items: Array<UserListItemModel>
}
