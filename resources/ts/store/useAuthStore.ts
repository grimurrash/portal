import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
  state: () => {
    return {
      userData: <UserModel|undefined>undefined
    }
  },
  actions: {
    setUserData(userData: UserModel) {
      this.userData = userData
    },
    getUserData(): UserModel
    {
      return this.userData as UserModel
    }
  },
})
