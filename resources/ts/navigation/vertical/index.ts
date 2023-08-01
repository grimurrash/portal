import demoNav from './demo'
import type { VerticalNavItems } from '@/@layouts/types'
import management from '@/navigation/vertical/management'
import activity from '@/navigation/vertical/activity'

export default [
  ...activity,
  ...management,
  ...demoNav,
] as VerticalNavItems
