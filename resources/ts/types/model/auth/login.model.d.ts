declare interface UserModel {
  id: number
  name: string
  email: string
  role: string
  avatar: ?string
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
