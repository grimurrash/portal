import type { AxiosResponse } from 'axios'
import axios from '@axios'

export const AuthService = {
  async login({ email, password, remember_me }: AuthLoginDto): Promise<AxiosResponse<LoginResponse>> {
    return axios.post<LoginResponse>('/auth/login', { email, password, remember_me })
  },
}
