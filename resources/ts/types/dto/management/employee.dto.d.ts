declare interface EmployeeListFilterDto {
  department_id: ?number
  gender: ?string
  is_founders_representative: ?boolean
  age_from: ?number
  age_to: ?number
  education_level: ?string
}

declare interface EmployeeListRequestDto {
  filters: EmployeeListFilterDto,
  options: TableOptions
}

declare interface ImportEmployeeRequestDto {
  file: ?File,
  sheetName: ?string
}
