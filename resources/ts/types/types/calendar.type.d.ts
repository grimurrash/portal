declare interface CalendarEvent {
  id: string
  title: string
  start: Date
  end: Date
  url: string
  allDay: boolean
  extendedProps: Record<string, any>
}
