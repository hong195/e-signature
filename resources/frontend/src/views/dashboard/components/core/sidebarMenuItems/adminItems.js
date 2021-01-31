export default [
  {
    icon: 'mdi-view-dashboard',
    title: 'mainPage',
    to: '/home',
  },
  {
    to: '/applications',
    icon: 'mdi-view-comfy',
    title: 'Заявки',
  },
  {
    icon: 'mdi-account-multiple',
    title: 'staff',
    group: '',
    children: [
      {
        to: 'staff',
        avatar: 'mdi-view-comfy',
        title: 'Пользователи',
      },
      {
        to: 'create-staff',
        avatar: 'mdi-clipboard-outline',
        title: 'Создать пользователя',
      },
    ],
  },
  {
    icon: 'mdi-arrange-bring-forward',
    title: 'Компании',
    group: '',
    children: [
      {
        to: 'company',
        avatar: 'mdi-view-comfy',
        title: 'Компании',
      },
      {
        to: 'create-company',
        avatar: 'mdi-clipboard-outline',
        title: 'Создать компанию',
      },
    ],
  },
]
