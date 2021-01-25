<template>
  <v-app>
    <pages-core-app-bar />
    <pages-core-view />
  </v-app>
</template>

<script>
  import PagesCoreAppBar from '@/views/pages/components/core/AppBar'
  export default {
    name: 'PagesIndex',

    components: {
      PagesCoreAppBar,
      PagesCoreView: () => import('./components/core/View'),
    },

    created () {
      this.$vuetify.theme.dark = this.$route.name !== 'login'
    },

    beforeDestroy () {
      this.$vuetify.theme.dark = false
    },
  }
</script>
