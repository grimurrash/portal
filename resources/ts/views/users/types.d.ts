import {Role} from "@/db/enums";

export interface UserParams {
  q: string,
  role: Array<Role>,
  options: object,
}
