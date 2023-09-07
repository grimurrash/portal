declare interface UserListItemModel {
  id: number
  name: string
  email: string
  roles: Array<string>
  permissions: Array<string>
}

declare interface UserListResponse extends PaginateListResponse{
  items: Array<UserListItemModel>
  total_count: number
}

declare interface UserInfoResponse {
  id: number
  name: string
  email: string
  roles: Array<string>
  permissions: Array<string>
}
