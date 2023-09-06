export enum RoleEnum {
  admin = 'admin',
  employee = 'employee',
  external_employee = 'external_employee',
  organizer = 'organizer',
}

export const RoleNames = {
  [RoleEnum.admin]: 'Админ',
  [RoleEnum.employee]: 'Сотрудник МЦПС',
  [RoleEnum.external_employee]: 'Внешний сотрудник',
  [RoleEnum.organizer]: 'Организатор проектов',
}
