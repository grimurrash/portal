declare interface OrganizationProjectListItemModel {
  id: number
  number: number
  status: number
  name: string
  description: string
  start_date: string | Date
  end_date: string | Date
  responsible_user_id: number
  responsible_user_name: string
  curator_user_id: number
  curator_user_name: string
  organizer_user_id: number
  organizer_user_name: string
  moderator_user_id: number
  moderator_user_name: string
  dates: OrganizationProjectDateItemModel[]
}

declare interface OrganizationProjectInfoModelDto {
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
  responsible_user_name: string
  curator_user_id: number
  curator_user_name: string
  organizer_user_id: number
  organizer_user_name: string
  moderator_user_id: ?number
  moderator_user_name: ?string
  change_logs: OrganizationProjectChangeLogItemModel[]
}

declare interface OrganizationProjectDateItemModel {
  name: ?string
  date: Date | string | null
}

declare interface OrganizationProjectChangeLogItemModel {
  name: string,
  user_id: number,
  user_name: string,
  datetime: string,
  description: string | null
}

declare interface OrganizationProjectCalendarItemModel extends CalendarEvent {
  extendedProps: {
    project_id: number
    project_name: string,
  },
}
