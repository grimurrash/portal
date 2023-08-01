declare interface LoginResponse {
  user: UserModel,
  abilities: Array<UserAbility>
  token: string,
  token_expired_at: number
}
