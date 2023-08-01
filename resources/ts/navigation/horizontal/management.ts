export default [
  {
    title: 'Управление',
    icon: { icon: 'tabler-file-text' },
    children: [
      {
        title: 'Отделы',
        icon: { icon: 'tabler-users' },
        to: 'departments-list',
      },
      {
        title: 'Пользователи',
        icon: { icon: 'tabler-users' },
        to: 'users-list',
      },
    ],
  },
]
