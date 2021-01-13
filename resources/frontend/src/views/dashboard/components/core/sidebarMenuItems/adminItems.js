export default [
    {
      icon: 'mdi-view-dashboard',
      title: 'mainPage',
      to: '/home',
    },
    {
      icon: 'mdi-account-multiple',
      title: 'staff',
      group: '',
      children: [
        {
          to: 'staff',
          avatar: 'mdi-view-comfy',
          title: 'staff',
        },
        {
          to: 'create-staff',
          avatar: 'mdi-clipboard-outline',
          title: 'createStaff',
        },
      ],
    },
  ]
