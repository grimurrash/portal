import axios from '@axios'
import { tableOptionsToObject } from '@/utils/utils'

export const UserService = {
  async create(data: CreateUserRequestDto) {
    return axios.post('/management/users/create', data)
  },
  async list(data: UserListRequestDto) {
    return axios.get<UserListResponse>('/management/users/index', {
      params: {
        ...data.filters,
        ...tableOptionsToObject(data.options),
      },
    })
  },
  async show(id: number){
    return axios.get<UserInfoResponse>(`/management/users/${id}/show`)
  },
  async update(user: UpdateUserRequestDto) {
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
  async userOptions() {
    return axios.get<OptionItemModel[]>('/management/users/options')
  },
}
