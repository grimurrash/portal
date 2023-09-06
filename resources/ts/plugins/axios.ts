import axios, { AxiosError } from 'axios'
import router from '@/router'

const prodUrl = '/api/'
const devUrl = 'http://127.0.0.1/api/'

const axiosIns = axios.create({
  baseURL: import.meta.env.PROD ? prodUrl : devUrl,
})

axiosIns.interceptors.request.use(config => {
  const token = localStorage.getItem('accessToken')

  if (token) {
    config.headers = config.headers || {}
    config.headers.Authorization = token ? `Bearer ${JSON.parse(token)}` : ''
  }

  return config
})

axiosIns.interceptors.response.use(response => {
  return response
}, (error: AxiosError) => {
  if (error.response?.status === 401) {
    localStorage.removeItem('userData')

    localStorage.removeItem('accessToken')
    localStorage.removeItem('userAbilities')

    return router.push('/login')
  }
  else {
    return Promise.reject(error.response)
  }
})

export default axiosIns
