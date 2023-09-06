import type { AxiosResponse } from 'axios'
import axios from '@axios'
import { tableOptionsToObject } from '@/utils/utils'

export const DepartmentService = {
  async list(data: DepartmentListRequestDto): Promise<AxiosResponse<PaginateListResponse<DepartmentListItemModel>>> {
    return axios.get<PaginateListResponse<DepartmentListItemModel>>('/management/departments', {
      params: {
        ...data.filters,
        ...tableOptionsToObject(data.options)
      },
    })
  },

  async parentDepartmentOptions(): Promise<AxiosResponse<OptionItemModel[]>> {
    return axios.get<OptionItemModel[]>('/management/departments/parent-department-options')
  },

  async allDepartmentOptions(): Promise<AxiosResponse<OptionItemModel[]>> {
    return axios.get<OptionItemModel[]>('/management/departments/all-department-options')
  },

  async update(department: DepartmentListItemModel) {
    return axios.put(`/management/departments/${department.id}/update`, {
      name: department.name,
      parent_department_id: department.parent_department_id,
      head_employee_id: department.head_employee_id,
    })
  },
}
