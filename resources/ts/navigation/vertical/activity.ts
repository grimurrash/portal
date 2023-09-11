export default [
  { heading: 'МЕРОПРИЯТИЯ' },
  {
    title: 'Календарь проектов',
    icon: { icon: 'tabler-calendar' },
    to: 'organization-project-calendar',
    action: 'read',
    subject: 'organizationProject',
  },
  {
    title: 'Проекты',
    icon: { icon: 'tabler-id' },
    subject: 'organizationProject',
    children: [
      {
        title: 'Мои проекты',
        to: 'organization-project-list',
        action: 'read',
        subject: 'organizationProject',
      },
      {
        title: 'Модерация',
        to: 'organization-project-moderated-list',
        action: 'update',
        subject: 'organizationProject',
      },
      {
        title: 'Все проекты',
        to: 'organization-project-general-list',
        action: 'all',
        subject: 'organizationProject',
      },
    ],
  },
  // {
  //   title: 'Облако слов',
  //   icon: { icon: 'tabler-users' },
  //   to: 'word-cloud',
  //   action: 'read',
  //   subject: 'WordCloud',
  // },
]
