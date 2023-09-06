export default [
  {
    title: 'Мероприятия',
    icon: { icon: 'tabler-file-text' },
    children: [
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
            icon: { icon: 'tabler-id' },
            action: 'create',
            subject: 'OrganizationProject',
          },
          {
            title: 'Модерация',
            to: 'organization-project-moderated-list',
            icon: { icon: 'tabler-circle-check' },
            action: 'moderate',
            subject: 'OrganizationProject',
          },
          {
            title: 'Все проекты',
            to: 'organization-project-general-list',
            icon: { icon: 'tabler-id' },
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
    ],
  },
]
