export enum RoleEnum {
  admin = 'admin',
  employee = 'employee',
  external_employee = 'external_employee',
  organization_project_organizer = 'organization_project_organizer',
  organization_project_moderator = 'organization_project_moderator'
}

export const RoleNames: Record<RoleEnum, string> = {
  [RoleEnum.admin]: 'Админ',
  [RoleEnum.employee]: 'Сотрудник МЦПС',
  [RoleEnum.external_employee]: 'Внешний сотрудник',
  [RoleEnum.organization_project_organizer]: 'Организатор проектов',
  [RoleEnum.organization_project_moderator]: 'Модератор проектов'
}
