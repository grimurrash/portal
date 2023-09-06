export enum PermissionEnum {
  manage_all = 'manage_all',
  read_department = 'read_department',
  update_department = 'update_department',
  delete_department = 'delete_department',
  export_department = 'export_department',
  read_employee = 'read_employee',
  export_employee = 'export_employee',
  import_employee = 'import_employee',
  read_user = 'read_user',
  update_user = 'update_user',
  delete_user = 'delete_user',
  create_user = 'create_user',
  read_organizationProject = 'read_organizationProject',
  create_organizationProject = 'create_organizationProject',
  update_organizationProject = 'update_organizationProject',
  control_organizationProject = 'control_organizationProject',
  read_WordCloud = 'read_WordCloud',
  create_WordCloud = 'create_WordCloud',
}

export const PermissionNames = {
  [PermissionEnum.manage_all]: 'Полный доступ',

  [PermissionEnum.read_department]: 'Просмотр отделов',
  [PermissionEnum.update_department]: 'Обновление отделов',
  [PermissionEnum.delete_department]: 'Удаление отделов',
  [PermissionEnum.export_department]: 'Экспорт отделов',

  [PermissionEnum.read_employee]: 'Просмотр сотрудников',
  [PermissionEnum.export_employee]: 'Экспорт сотрудников',
  [PermissionEnum.import_employee]: 'Импорт сотрудников',

  [PermissionEnum.read_user]: 'Просмотр пользователей',
  [PermissionEnum.create_user]: 'Создание пользователей',
  [PermissionEnum.update_user]: 'Обновление пользователей',
  [PermissionEnum.delete_user]: 'Удаление пользователей',

  [PermissionEnum.read_organizationProject]: 'Просмотр проектов',
  [PermissionEnum.create_organizationProject]: 'Создание проектов',
  [PermissionEnum.update_organizationProject]: 'Обновление проектов',
  [PermissionEnum.control_organizationProject]: 'Контроль проектов',

  [PermissionEnum.read_WordCloud]: 'Просмотр облака слов',
  [PermissionEnum.create_WordCloud]: 'Создание облака слов',
}

