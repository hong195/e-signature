<template>
  <div>
    <v-btn
      v-for="(action, i) in actions"
      :key="i"
      dark
      class="px-2 ml-1"
      :color="action.color"
      min-width="0"
      small
      @click="actionMethod(action.method)"
    >
      <v-icon small v-text="action.icon" />
    </v-btn>
  </div>
</template>

<script>
  import can from '@/plugins/directives/v-can'

  export default {
    name: 'Actions',
    directives: {
      can: can,
    },
    props: {
      nextRoute: {
        type: String,
      },
      fetchUrl: {
        type: String,
      },
      item: {
        type: Object,
        default: () => ({}),
      },
      mutation: {
        type: String,
      },
      getter: {
        type: String,
      },
    },
    data () {
      return {
        activeItem: {},
        actions: [
          {
            color: 'success',
            icon: 'mdi-pencil',
            can: 'update',
            method: 'editItem',
          },
          {
            color: 'error',
            icon: 'mdi-close',
            can: 'delete',
            method: 'deleteItem',
          },
        ],
      }
    },
    methods: {
      actionMethod (funcName, item) {
        this[funcName](item)
      },
      editItem () {
        this.$router.push({
          name: this.nextRoute,
          params: { id: this.item.id },
        })
      },
      deleteItem () {
        this.$http
          .delete(`${this.fetchUrl}/${this.item.id}`)
          .then((response) => {
            const items = this.$store.getters[this.getter]
            items.splice(
              items.findIndex(({ id }) => id === this.item.id),
              1,
            )
            this.$store.commit(this.mutation, items)
            this.$store.commit('successMessage', response.data.message)
          })
          .catch(error => {
            console.error(error)
            this.$store.commit('errorMessage', error)
          })
      },
    },
  }
</script>
