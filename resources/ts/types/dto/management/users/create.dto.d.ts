import { RoleEnum } from '@/types/enums/role.enum'

declare interface CreateUserDto {
  name: string,
  email: string,
  password: string,
  role: RoleEnum | undefined,
  isEmailVerified: boolean,
}
