import { setupLayouts } from 'virtual:generated-layouts'
import { createRouter, createWebHistory } from 'vue-router'
import { getHomePage, isUserLoggedIn } from './utils'
import routes from '~pages'
import { canNavigate } from '@layouts/plugins/casl'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: to => {
        const isLoggedIn = isUserLoggedIn()

        if (isLoggedIn) {
          const userData = JSON.parse(localStorage.getItem('userData') || '{}')
          const userRole: string = (userData && userData.role) ? userData.role : null

          return getHomePage(userRole)
        }

        return { name: 'login', query: to.query }
      },
    },
    {
      path: '/demo/pages/user-profile',
      redirect: () => ({ name: 'demo-pages-user-profile-tab', params: { tab: 'profile' } }),
    },
    {
      path: '/demo/pages/account-settings',
      redirect: () => ({ name: 'demo-pages-account-settings-tab', params: { tab: 'account' } }),
    },
    ...setupLayouts(routes),
  ],
})

router.beforeEach(to => {
  const isLoggedIn = isUserLoggedIn()

  if (canNavigate(to)) {
    if (to.meta.redirectIfLoggedIn && isLoggedIn)
      return '/'
  }
  else {
    if (isLoggedIn)
      return { name: 'not-authorized' }
    else
      return { name: 'login', query: { to: to.name !== 'index' ? to.fullPath : undefined } }
  }
})

export default router
