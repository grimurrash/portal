import type { AxiosResponse } from 'axios'
import axios from '@axios'

export const DepartmentService = {
  async list(data: DepartmentListRequestDto): Promise<AxiosResponse<DepartmentListResponse>> {
    let sortBy
    if (data.options.sortBy.length > 0)
      sortBy = data.options.sortBy[0]

    return axios.get<DepartmentListResponse>('/management/departments', {
      params: {
        search: data.options.search,
        parent_department_id: data.filters.parentDepartmentId,
        page: data.options.page,
        per_page: data.options.itemsPerPage,
        sort_column: sortBy?.key ?? undefined,
        sort_order: sortBy?.order ?? undefined,
      },
    })
  },

  async parentDepartmentOptions(): Promise<AxiosResponse<DepartmentOptionItemModel[]>> {
    return axios.get<DepartmentOptionItemModel[]>('/management/departments/parent-department-options')
  },

  async allDepartmentOptions(): Promise<AxiosResponse<DepartmentOptionItemModel[]>> {
    return axios.get<DepartmentOptionItemModel[]>('/management/departments/all-department-options')
  },

  async update(department: DepartmentListItemModel) {
    return axios.put(`/management/departments/${department.id}/update`, {
      name: department.name,
      parent_department_id: department.parent_department_id,
      head_employee_id: department.head_employee_id,
    })
  },
}
