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

// SECTION
// App: Department
export interface DepartmentProperties {
  id: number
  title: string
  parentalDepartment: string
  head: string
  numberOfStaff: number
}
// !SECTION
