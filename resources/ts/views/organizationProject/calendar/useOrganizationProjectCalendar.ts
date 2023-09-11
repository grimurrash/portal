import type { CalendarApi, CalendarOptions, EventApi, EventSourceFunc } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import listPlugin from '@fullcalendar/list'
import timeGridPlugin from '@fullcalendar/timegrid'
import type { Ref } from 'vue'
import { OrganizationProjectService } from '@/services/activity/organization-project.service'

export const blankEvent = {
  id: '',
  title: '',
  start: new Date(),
  end: new Date(),
  url: '',
  allDay: false,
  extendedProps: {
    project_id: 0,
    project_name: '',
  },
}

const calendarsColors = {
  0: 'primary',
  1: 'success',
  2: 'error',
  3: 'warning',
  4: 'info',
}

export const useCalendar = (event: Ref<OrganizationProjectCalendarItemModel>, isEventHandlerSidebarActive: Ref<boolean>, isLeftSidebarOpen: Ref<boolean>) => {
  const refCalendar = ref()

  const extractEventDataFromEventApi = (eventApi: EventApi)=> {
    return {
      id: eventApi.id,
      title: eventApi.title,
      start: eventApi.start,
      end: eventApi.end,
      url: eventApi.url,
      extendedProps: {
        project_id: eventApi.extendedProps.project_id as number,
        project_name: eventApi.extendedProps.project_name,
      },
      allDay: eventApi.allDay,
    } as OrganizationProjectCalendarItemModel
  }

  // 👉 Fetch events
  const fetchEvents: EventSourceFunc = (info, successCallback) => {
    if (!info)
      return

    OrganizationProjectService.calendar().then(res => {
      successCallback((res.data ?? []).map((e: OrganizationProjectCalendarItemModel) => ({
        ...e,
        start: e.start,
        end: e.end,
      })))
    })


  }

  // 👉 Calendar API
  const calendarApi = ref<null | CalendarApi>(null)

  // 👉 Calendar options
  const calendarOptions = {
    plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin, listPlugin],
    initialView: 'dayGridMonth',
    headerToolbar: {
      start: 'drawerToggler,prev,next title',
      end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',
    },
    events: fetchEvents,

    forceEventDuration: true,

    editable: false,

    eventResizableFromStart: true,

    dragScroll: true,

    dayMaxEvents: 5,

    navLinks: true,

    eventClassNames({ event: calendarEvent }) {
      const colorName = calendarsColors[calendarEvent._def.extendedProps.project_id % 5 as keyof typeof calendarsColors]

      return [
        `bg-light-${colorName} text-${colorName}`,
      ]
    },

    eventClick({ event: clickedEvent }) {
      // * Only grab required field otherwise it goes in infinity loop
      // ! Always grab all fields rendered by form (even if it get `undefined`) otherwise due to Vue3/Composition API you might get: "object is not extensible"
      event.value = extractEventDataFromEventApi(clickedEvent)

      isEventHandlerSidebarActive.value = true
    },

    // customButtons
    dateClick(info) {
      event.value = { ...event.value, start: info.date }

      isEventHandlerSidebarActive.value = true
    },

    customButtons: {
      drawerToggler: {
        text: 'calendarDrawerToggler',
        click() {
          isLeftSidebarOpen.value = true
        },
      },
    },
  } as CalendarOptions

  // 👉 onMounted
  onMounted(() => {
    calendarApi.value = refCalendar.value.getApi()
  })

  // 👉 Jump to date on sidebar(inline) calendar change
  const jumpToDate = (currentDate: string) => {
    calendarApi.value?.gotoDate(new Date(currentDate))
  }

  return {
    refCalendar,
    calendarOptions,
    fetchEvents,
    jumpToDate,
  }
}
