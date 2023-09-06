export default [
  {
    title: 'Управление',
    icon: { icon: 'tabler-file-text' },
    children: [
      {
        title: 'Отделы',
        icon: { icon: 'tabler-users' },
        to: 'management-department-list',
      },
      {
        title: 'Сотрудники',
        icon: { icon: 'tabler-users' },
        to: 'management-employee-list',
      },
      // {
      //   title: 'Пользователи',
      //   icon: { icon: 'tabler-users' },
      //   to: 'users-list',
      // },
    ],
  },
]
