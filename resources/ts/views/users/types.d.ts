import {Permission, Role} from "@/db/enums";
import {Options} from "@core/types";

export interface UserParams {
  q: string,
  role: Array<Role>,
  permission: Array<Permission>
  options: Options,
}
