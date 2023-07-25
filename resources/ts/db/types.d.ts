// SECTION
// App: User
import {Permission, Role} from "@/db/enums";

export interface UserProperties {
  id: number
  fullName: string
  email: string
  role: Array<Role>
  permission: Array<Permission>
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
