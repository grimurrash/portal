import axios from '@axios'

export const UserService = {
  async index() {
    return axios.get('/management/users/index')
  },
}
