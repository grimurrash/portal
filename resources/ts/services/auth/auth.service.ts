import axios from '@axios'

export const AuthService = {
  async login({ email, password, remember_me }: AuthLoginDto) {
    return axios.post<LoginResponse>('/auth/login', { email, password, remember_me })
  },
}
