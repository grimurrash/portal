import axios from '@axios'
import { AxiosResponse } from 'axios'
import { UserListRequestDto } from '@/types/dto/management/users/list.dto'
import { ShowUserResponse, UserListItemModel, UserListResponse } from '@/types/model/management/user.model'
import { CreateUserDto } from '@/types/dto/management/users/create.dto'
import { RoleEnum, roleKeyByValue, RoleNames } from '@/types/enums/role.enum'
import { PermissionEnum, permissionKeyByValue, PermissionNames } from '@/types/enums/permission.enum'

export const UserService = {
  async create({ name, email, password, roles, permissions, isEmailVerified }: CreateUserDto) {
    for (let i = 0; i < roles.length; i++) {
      roles[i] = roleKeyByValue(RoleNames, roles[i]) as RoleEnum
    }
    for (let i = 0; i <permissions.length; i++) {
      permissions[i] = permissionKeyByValue(PermissionNames, permissions[i]) as PermissionEnum
    }
    return axios.post('/management/users/create', { name, email, password, roles, permissions, isEmailVerified })
  },
  async list(data: UserListRequestDto): Promise<AxiosResponse<UserListResponse>> {
    let sortBy
    if (data.options.sortBy.length > 0)
      sortBy = data.options.sortBy[0]
    return axios.get<UserListResponse>('/management/users/index', {
      params: {
        search: data.options.search,
        role: data.filters.role ? roleKeyByValue(RoleNames, data.filters.role) : undefined,
        permission: data.filters.permission ? permissionKeyByValue(PermissionNames, data.filters.permission) : undefined,
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
      user.roles[i] = roleKeyByValue(RoleNames, user.roles[i]) as RoleEnum
    }
    for (let i = 0; i < user.permissions.length; i++) {
      user.permissions[i] = permissionKeyByValue(PermissionNames, user.permissions[i]) as PermissionEnum
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
