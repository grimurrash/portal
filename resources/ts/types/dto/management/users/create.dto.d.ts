import { RoleEnum } from '@/types/enums/role.enum'
import { PermissionEnum } from '@/types/enums/permission.enum'

declare interface CreateUserDto {
  name: string,
  email: string,
  password: string,
  roles: Array<RoleEnum>,
  permissions: Array<PermissionEnum>,
  isEmailVerified: boolean,
}
