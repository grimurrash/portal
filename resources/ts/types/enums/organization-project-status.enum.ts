export enum OrganizationProjectStatusEnum {
  CANCEL = -1,
  CREATE = 1,
  MODERATION = 2,
  APPROVE = 3,
  FINISH = 4,
}

export const OrganizationProjectStatusNames = {
  [OrganizationProjectStatusEnum.CANCEL]: 'Отменен',
  [OrganizationProjectStatusEnum.CREATE]: 'Создан',
  [OrganizationProjectStatusEnum.MODERATION]: 'На модерации',
  [OrganizationProjectStatusEnum.APPROVE]: 'Прошел модерацию',
  [OrganizationProjectStatusEnum.FINISH]: 'Завершен',
}
export const OrganizationProjectStatusColors = {
  [OrganizationProjectStatusEnum.CANCEL]: 'error',
  [OrganizationProjectStatusEnum.CREATE]: 'secondary',
  [OrganizationProjectStatusEnum.MODERATION]: 'warning',
  [OrganizationProjectStatusEnum.APPROVE]: 'info',
  [OrganizationProjectStatusEnum.FINISH]: 'success',
}
