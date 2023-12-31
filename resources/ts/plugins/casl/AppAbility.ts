import type { AbilityClass } from '@casl/ability'
import { Ability } from '@casl/ability'

export type AppAbility = Ability<[Actions, Subjects]>

// eslint-disable-next-line @typescript-eslint/no-redeclare
export const AppAbility = Ability as AbilityClass<AppAbility>
