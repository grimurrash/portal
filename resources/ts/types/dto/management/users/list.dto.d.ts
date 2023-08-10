import { RoleEnum } from '@/types/enums/role.enum'

declare interface UserListFilterDto {
  role: RoleEnum | undefined
}

declare interface UserListRequestDto {
  filters: UserListFilterDto,
  options: TableOptions
}
