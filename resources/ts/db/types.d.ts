// !SECTION

// SECTION
// App: User
import {Role} from "@/db/enums";

export interface UserProperties {
  id: number
  fullName: string
  email: string
  role: Array<Role>
  avatar: string
}
// !SECTION
