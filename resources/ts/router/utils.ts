import { RoleEnum } from '@/types/enums/role.enum'

/**
 * Return if user is logged in
 * This is completely up to you and how you want to store the token in your frontend application
 * e.g. If you are using cookies to store the application please update this function
 */
export const isUserLoggedIn = () => {
  const expiresAt = Number(localStorage.getItem('accessTokenExpiredAt') ?? 0)

  if (expiresAt < Date.now() + 86400)
    return false

  return !!(localStorage.getItem('userData') && localStorage.getItem('accessToken'))
}

export const getHomePage = (roleId: string) => {
  const role = RoleEnum[roleId]
  if (role === RoleEnum.admin)
    return { name: 'demo-dashboards-ecommerce' }

  return { name: 'demo-dashboards-analytics' }
}
