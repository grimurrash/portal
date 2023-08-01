// SECTION
// Management: User
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
// Management: Department
export interface DepartmentProperties {
  id: number
  title: string
  parentalDepartment: string
  head: string
  numberOfStaff: number
}
// !SECTION

// SECTION
// Events: Word cloud
export interface WordCloudProperties {
  id: number
  event: string
  question: string
  creator: string
  cloudLink: string
  questionLink: string
  numberOfResponses: number
  textColor: string
  uniqueCheckbox: boolean
  wordCloudTitle: string
  backgroundImage: string
  logo?: string
  exceptions?: string
  extraCSS?: string
  minTextSize: number
  maxTextSize: number
  numberOfResponsesCheckbox: boolean
  numberOfResponsesSize: number
  textRotationAngle: number
}
// !SECTION
