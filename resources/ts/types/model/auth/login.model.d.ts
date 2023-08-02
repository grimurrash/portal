declare interface UserModel {
  id: number
  email: string
  password: string
  role: string
}

declare interface UserAbility {
  action: Actions
  subject: Subjects
}

declare interface LoginResponse {
  user: UserModel,
  abilities: Array<UserAbility>
  token: string,
  token_expired_at: number
}
