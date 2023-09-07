declare interface UpdateUserRequestDto {
  id: number
  name: string
  email: string
  roles: Array<string>
  permissions: Array<string>
}

declare interface CreateUserRequestDto {
  name: string,
  email: string,
  password: string,
  roles: Array<string>,
  permissions: Array<string>,
  isEmailVerified: boolean,
}

declare interface UserListFilterDto {
  role: ?string
  permission: ?string
}

declare interface UserListRequestDto {
  filters: UserListFilterDto,
  options: TableOptions
}
