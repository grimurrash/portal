declare interface DepartmentListFilterDto {
  parentDepartmentId: number | undefined
}

declare interface DepartmentListRequestDto {
  filters: DepartmentListFilterDto,
  options: TableOptions
}
