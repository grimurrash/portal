import axios from 'axios'
import router from '@/router'

const axiosIns = axios.create({
  baseURL: 'http://localhost:8000/api/',

  // timeout: 1000,
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
}, error => {
  if (error.response.status === 401) {
    localStorage.removeItem('userData')

    localStorage.removeItem('accessToken')
    localStorage.removeItem('userAbilities')

    return router.push('/login')
  }
  else {
    return Promise.reject(error)
  }
})

export default axiosIns
