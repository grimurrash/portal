import type { AxiosResponse } from 'axios'
import axios from '@axios'
import { tableOptionsToObject } from '@/utils/utils'

export const EmployeeService = {
  async list (data: EmployeeListRequestDto): Promise<AxiosResponse<PaginateListResponse<EmployeeListItemModel>>> {
    return axios.get<PaginateListResponse<EmployeeListItemModel>>('/management/employees', {
      params: {
        ...data.filters,
        ...tableOptionsToObject(data.options)
      },
    })
  },
  async importEmployees (data: ImportEmployeeRequestDto) {
    const formData = new FormData()
    if (data.file) {
      formData.append('file', data.file)
    }
    if (data.sheetName) {
      formData.append('sheet_name', data.sheetName)
    }
    return axios.post('/management/employees/import', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      }
    })
  },
  async employeesOptionsByDepartmentId (departmentId: number): Promise<AxiosResponse<OptionItemModel[]>> {
    return axios.get<OptionItemModel[]>('/management/employees/options-by-department', {
      params: {
        department_id: departmentId,
      },
    })
  },
}
