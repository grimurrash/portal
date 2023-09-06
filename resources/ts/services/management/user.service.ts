import axios from '@axios'
import { AxiosResponse } from 'axios'
import { UserListRequestDto } from '@/types/dto/management/users/list.dto'
import { ShowUserResponse, UserListItemModel, UserListResponse } from '@/types/model/management/user.model'
import { CreateUserDto } from '@/types/dto/management/users/create.dto'
import { toPermissionEnum, toRoleEnum } from '@/types/enums/utils'

export const UserService = {
  async create({ name, email, password, role, isEmailVerified }: CreateUserDto) {
    role = toRoleEnum(role)
    return axios.post('/management/users/create', { name, email, password, role, isEmailVerified })
  },
  async list(data: UserListRequestDto): Promise<AxiosResponse<UserListResponse>> {
    let sortBy
    if (data.options.sortBy.length > 0)
      sortBy = data.options.sortBy[0]
    return axios.get<UserListResponse>('/management/users/index', {
      params: {
        search: data.options.search,
        role: toRoleEnum(data.filters.role),
        permission: toPermissionEnum(data.filters.permission),
        page: data.options.page,
        per_page: data.options.itemsPerPage,
        sort_column: sortBy?.key ?? undefined,
        sort_order: sortBy?.order ?? undefined,
      },
    })
  },
  async show(id: number): Promise<AxiosResponse<ShowUserResponse>>{
    return axios.get<ShowUserResponse>(`/management/users/${id}/show`)
  },
  async update(user: UserListItemModel) {
    for (let i = 0; i < user.roles.length; i++) {
      user.roles[i] = toRoleEnum(user.roles[i])
    }
    for (let i = 0; i < user.permissions.length; i++) {
      user.permissions[i] = toPermissionEnum(user.permissions[i])
    }
    return axios.put(`/management/users/${user.id}/update`, {
      name: user.name,
      email: user.email,
      roles: user.roles,
      permissions: user.permissions,
    })
  },
  async delete(id: number) {
    return axios.delete(`/management/users/${id}/delete`)
  },
  async userOptions(): Promise<AxiosResponse<OptionItemModel[]>> {
    return axios.get<OptionItemModel[]>('/management/users/options')
  },
}
