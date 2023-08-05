import type { AxiosResponse } from 'axios'
import axios from '@axios'

export const EmployeeService = {
  async employeesOptionsByDepartmentId(departmentId: number): Promise<AxiosResponse<EmployeeOptionItemModel[]>> {
    return axios.get<EmployeeOptionItemModel[]>('/management/employees/options-by-department', {
      params: {
        department_id: departmentId,
      },
    })
  },
}
