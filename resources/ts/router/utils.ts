import { RoleEnum } from '@/types/enums/role.enum'

export const isUserLoggedIn = () => {
  const expiresAt = Number(localStorage.getItem('accessTokenExpiredAt') ?? 0)

  if (expiresAt < Date.now() + 86400)
    return false

  return !!(localStorage.getItem('userData') && localStorage.getItem('accessToken'))
}

export const getHomePage = (role: string) => {
  if (role === RoleEnum.admin)
    return { name: 'organization-project-calendar' }

  return { name: 'organization-project-calendar' }
}
