export default [
  {
    title: 'Мероприятия',
    icon: { icon: 'tabler-file-text' },
    children: [
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
        children: [
          {
            title: 'Мои проекты',
            to: 'organization-project-list',
            icon: { icon: 'tabler-id' },
            action: 'read',
            subject: 'organizationProject',
          },
          {
            title: 'Модерация',
            to: 'organization-project-moderated-list',
            icon: { icon: 'tabler-circle-check' },
            action: 'update',
            subject: 'organizationProject',
          },
          {
            title: 'Все проекты',
            to: 'organization-project-general-list',
            icon: { icon: 'tabler-id' },
            action: 'control',
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
    ],
  },
]
