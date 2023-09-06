export default [
  { heading: 'МЕРОПРИЯТИЯ' },
  {
    title: 'Календарь проектов',
    icon: { icon: 'tabler-calendar' },
    to: 'organization-project-calendar',
  },
  {
    title: 'Проекты',
    icon: { icon: 'tabler-id' },
    subject: 'OrganizationProject',
    children: [
      {
        title: 'Мои проекты',
        to: 'organization-project-list',
        action: 'create',
        subject: 'OrganizationProject',
      },
      {
        title: 'Модерация',
        to: 'organization-project-moderated-list',
        action: 'moderate',
        subject: 'OrganizationProject',
      },
      {
        title: 'Все проекты',
        to: 'organization-project-general-list',
        action: 'all',
        subject: 'OrganizationProject',
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
