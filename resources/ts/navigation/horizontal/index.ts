import demoNav from '@/navigation/horizontal/demo'
import type { HorizontalNavItems } from '@layouts/types'
import management from '@/navigation/horizontal/management'
import activity from '@/navigation/horizontal/activity'

export default [
  ...activity,
  ...management,
  demoNav,
] as HorizontalNavItems
