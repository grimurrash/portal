import type { AxiosResponse } from 'axios'
import axios from '@axios'

export const UserService = {
  async userOptions(): Promise<AxiosResponse<OptionItemModel[]>> {
    return axios.get<OptionItemModel[]>('/management/users/options')
  },
}
