declare interface OrganizationProjectFilterDto {
  status: number | undefined,
  startDate: Date | string | undefined
  endDate: Date | string | undefined
}

declare interface OrganizationProjectListRequestDto {
  filters: OrganizationProjectFilterDto
  options: TableOptions
}

declare interface CreateOrganizationProjectRequestDto {
  number: ?number
  name: ?string
  description: ?string
  start_date: ?Date
  end_date: ?Date
  dates: OrganizationProjectDateItemModel[]
  metrics: ?string
  planned_coverage: ?number
  actual_coverage: ?number
  responsible_user_id: ?number
  curator_user_id: ?number
}

declare interface UpdateOrganizationProjectRequestDto {
  id: number
  number: number
  name: string
  description: string
  start_date: Date
  end_date: Date
  dates: OrganizationProjectDateItemModel[]
  metrics: string
  planned_coverage: number
  actual_coverage: number
  responsible_user_id: number
  curator_user_id: number
}

