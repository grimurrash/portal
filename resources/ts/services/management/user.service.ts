import axios from '@axios'
import { AxiosResponse } from 'axios'
import { UserListRequestDto } from '@/types/dto/management/users/list.dto'
import { UserListResponse } from '@/types/model/management/user.model'

export const UserService = {
  async list(data: UserListRequestDto): Promise<AxiosResponse<UserListResponse>> {
    let sortBy
    if (data.options.sortBy.length > 0)
      sortBy = data.options.sortBy[0]

    return axios.get<UserListResponse>('/management/users', {
      params: {
        search: data.options.search,
        page: data.options.page,
        per_page: data.options.itemsPerPage,
        sort_column: sortBy?.key ?? undefined,
        sort_order: sortBy?.order ?? undefined,
      },
    })
  },
}
