import type { UserProperties } from '@/db/types'
import { genId, paginateArray } from '@/db/utils'
import { Role } from '@/db/enums'
import avatar1 from '@images/avatars/avatar-1.png'
import mock from '@/@fake-db/mock'

const users: UserProperties[] = [
  {
    id: 1,
    fullName: 'Иванов Иван',
    email: 'gslixby0@abc.net.au',
    role: [Role.Employee],
    avatar: avatar1,
  },
  {
    id: 2,
    fullName: 'Иванов Иван Иваныч',
    email: 'hredmore1@imgur.com',
    role: [Role.Admin],
    avatar: '',
  },
]

// 👉  return users

mock.onGet('/db/users/list').reply(config => {
  console.log(config.url)

  const { q = '', role = null, options = {} } = config.params ?? {}

  const { sortBy = '', itemsPerPage = 10, page = 1 } = options

  const queryLower = q.toLowerCase()

  // filter users
  let filteredUsers = users.filter(user => ((user.fullName.toLowerCase().includes(queryLower) || user.email.toLowerCase().includes(queryLower)) && user.role === (role || user.role))).reverse()

  // sort users
  const sort = JSON.parse(JSON.stringify(sortBy))
  if (sort.length && sort[0]?.key === 'user') {
    filteredUsers = filteredUsers.sort((a, b) => {
      if (sort[0]?.order === 'asc')
        return a.fullName.localeCompare(b.fullName)
      else
        return b.fullName.localeCompare(a.fullName)
    })
  }

  const totalUsers = filteredUsers.length

  // total pages
  const totalPages = Math.ceil(totalUsers / itemsPerPage)

  return [200, {
    users: paginateArray(filteredUsers, itemsPerPage, page),
    totalPages,
    totalUsers,
    page: page > Math.ceil(totalUsers / itemsPerPage) ? 1 : page,
  }]
})

// 👉 Add user
mock.onPost('/db/users/user').reply(config => {
  const { user } = JSON.parse(config.data)

  user.id = genId(users)

  users.push(user)

  return [201, { user }]
})

// 👉 Get Single user
mock.onGet(/\/db\/users\/\d+/).reply(config => {
  // Get event id from URL
  const userId = config.url?.substring(config.url.lastIndexOf('/') + 1)

  // Convert Id to number
  const Id = Number(userId)

  const userIndex = users.findIndex(e => e.id === Id)

  const user = users[userIndex]

  Object.assign(user, {
    taskDone: 1230,
    projectDone: 568,
    taxId: 'Tax-8894',
    language: 'English',
  })

  if (user)
    return [200, user]

  return [404]
})

mock.onDelete(/\/db\/users\/\d+/).reply(config => {
  // Get user id from URL
  const userId = config.url?.substring(config.url.lastIndexOf('/') + 1)

  // Convert Id to number
  const Id = Number(userId)

  const userIndex = users.findIndex(e => e.id === Id)

  if (userIndex >= 0) {
    users.splice(userIndex, 1)

    return [200]
  }

  return [400]
})