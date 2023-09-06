import { defineStore } from 'pinia'

export const useNotificationStore = defineStore('notification', {
  state: () => {
    return {
      errorMessage: '',
      isSnackbarVisible: false
    }
  },
  actions: {
    sendErrorNotification(error: string) {
      this.errorMessage = error
      this.isSnackbarVisible = true
    }
  },
})
