import type { VerticalNavItems } from '@/@layouts/types'
import management from '@/navigation/vertical/management'
import activity from '@/navigation/vertical/activity'
// import demoNav from '@/navigation/vertical/demo'

export default [
  ...activity,
  ...management,
  // ...demoNav,
] as VerticalNavItems
