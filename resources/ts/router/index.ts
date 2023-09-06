import { setupLayouts } from 'virtual:generated-layouts'
import { createRouter, createWebHistory } from 'vue-router'
import { getHomePage, isUserLoggedIn } from './utils'
import routes from '~pages'
import { canNavigate } from '@layouts/plugins/casl'
import { RoleEnum } from '@/types/enums/role.enum'

const devUrl = import.meta.env.BASE_URL
const prodUrl = '/'

const router = createRouter({
  history: createWebHistory(import.meta.env.PROD ? prodUrl : devUrl),
  routes: [
    {
      path: '/',
      redirect: to => {
        const isLoggedIn = isUserLoggedIn()

        if (isLoggedIn) {
          const userData = JSON.parse(localStorage.getItem('userData') || '{}')
          const userRole: RoleEnum = (userData && userData.role) ? userData.role : null
          return getHomePage(userRole)
        }

        return { name: 'login', query: to.query }
      },
    },
    ...setupLayouts(routes),
  ],
})

router.beforeEach(to => {
  const isLoggedIn = isUserLoggedIn()

  if (canNavigate(to)) {
    if (to.meta.redirectIfLoggedIn && isLoggedIn)
      return '/'
  } else {
    if (isLoggedIn)
      return { name: 'organization-project-calendar' }
    else
      return { name: 'login', query: { to: to.name !== 'index' ? to.fullPath : undefined } }
  }
})

export default router
