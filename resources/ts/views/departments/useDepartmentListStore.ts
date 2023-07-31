import { defineStore } from 'pinia'
import type { DepartmentProperties } from '@/db/types'
import type { DepartmentParams } from '@/views/departments/types'
import { paginateArray } from '@/db/utils'

const departments: DepartmentProperties[] = [
  {
    id: 1,
    title: 'Контрагенты',
    parentalDepartment: 'Внешние лица и организации',
    head: '',
    numberOfStaff: 1,
  },
  {
    id: 2,
    title: 'Аналитический отдел',
    parentalDepartment: 'Антохин Владимир Александрович',
    head: 'Сураев Михаил Анатольевич',
    numberOfStaff: 5,
  },
]

export const useDepartmentListStore = defineStore('DepartmentListStore', {
  actions: {

    // 👉 Fetch departments data
    // eslint-disable-next-line sonarjs/cognitive-complexity
    fetchDepartments(params: DepartmentParams) {
      const q = params.q
      const options = params.options

      const { sortBy = '', itemsPerPage = 10, page = 1 } = options

      const queryLower = q.toLowerCase()

      // filter departments
      let filteredDepartments = departments.filter(department => (
        department.title.toLowerCase().includes(queryLower)
        || department.parentalDepartment.toLowerCase().includes(queryLower)
        || department.head.toLowerCase().includes(queryLower))).reverse()

      // sort departments
      const sort = JSON.parse(JSON.stringify(sortBy))
      if (sort.length && sort[0]?.key === 'title') {
        filteredDepartments = filteredDepartments.sort((a, b) => {
          if (sort[0]?.order === 'asc')
            return a.title.localeCompare(b.title)
          else
            return b.title.localeCompare(a.title)
        })
      }
      if (sort.length && sort[0]?.key === 'parentalDepartment') {
        filteredDepartments = filteredDepartments.sort((a, b) => {
          if (sort[0]?.order === 'asc')
            return a.parentalDepartment.localeCompare(b.parentalDepartment)
          else
            return b.parentalDepartment.localeCompare(a.parentalDepartment)
        })
      }
      if (sort.length && sort[0]?.key === 'head') {
        filteredDepartments = filteredDepartments.sort((a, b) => {
          if (sort[0]?.order === 'asc')
            return a.head.localeCompare(b.head)
          else
            return b.head.localeCompare(a.head)
        })
      }
      if (sort.length && sort[0]?.key === 'numberOfStaff') {
        filteredDepartments = filteredDepartments.sort((a, b) => {
          if (sort[0]?.order === 'asc')
            return a.numberOfStaff - b.numberOfStaff
          else
            return b.numberOfStaff - a.numberOfStaff
        })
      }

      const totalDepartments = filteredDepartments.length

      // total pages
      const totalPages = Math.ceil(totalDepartments / itemsPerPage)

      return {
        departments: paginateArray(filteredDepartments, itemsPerPage, page),
        totalPages,
        totalDepartments,
        page: page > Math.ceil(totalDepartments / itemsPerPage) ? 1 : page,
      }
    },
  },
})
