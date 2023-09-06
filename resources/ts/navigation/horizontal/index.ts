import type { HorizontalNavItems } from '@layouts/types'
import management from '@/navigation/horizontal/management'
import activity from '@/navigation/horizontal/activity'
// import demoNav from '@/navigation/horizontal/demo'

export default [
  ...activity,
  ...management,
  // demoNav,
] as HorizontalNavItems
