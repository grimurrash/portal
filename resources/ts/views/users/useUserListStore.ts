import type {AxiosResponse} from 'axios'
import {defineStore} from 'pinia'
import type {UserProperties} from '@/db/types'
import type {UserParams} from '@/views/users/types'
import axios from '@axios'

export const useUserListStore = defineStore('MyUserListStore', {
  actions: {


    // 👉 Fetch users data
    fetchUsers(params: UserParams) {
      return axios.get('/db/users/list', { params })
    },

    // 👉 Add User
    addUser(userData: UserProperties) {
      return new Promise((resolve, reject) => {
        axios.post('/db/users/user', {
          user: userData,
        }).then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single user
    fetchUser(id: number) {
      return new Promise<AxiosResponse>((resolve, reject) => {
        axios.get(`/db/users/${id}`).then(response => resolve(response)).catch(error => reject(error))
      })
    },

    // 👉 Delete User
    deleteUser(id: number) {
      return new Promise((resolve, reject) => {
        axios.delete(`/db/users/${id}`).then(response => resolve(response)).catch(error => reject(error))
      })
    },
  },
})
