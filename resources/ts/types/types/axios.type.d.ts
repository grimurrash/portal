declare interface BaseAxiosErrorResponse {
  message: string
}

declare interface UnprocessableErrorResponse extends BaseAxiosErrorResponse {
  message: string
  errors: Record<string, string>
}
