declare interface EmployeeListItemModel {
  id: number
  name: string
  parent_department_id: number | undefined
  parent_department_name: string | undefined
  head_employee_id: number | undefined
  head_employee_name: string | undefined
  employees_count: number
}
