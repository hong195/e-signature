<template>
  <v-container id="data-tables" tag="section">
    <base-material-card
      color="indigo"
      icon="mdi-account-multiple"
      inline
      class="px-5 py-3 mt-6"
    >
      <div class="d-flex">
        <v-text-field
          v-model.lazy="searchParams.name"
          append-icon="mdi-magnify"
          class="ml-auto mr-3"
          label="Поиск"
          hide-details
          outlined
          style="max-width: 250px"
        />
      </div>

      <v-divider class="mt-3" />
      <data-table
        ref="data-table"
        fetch-url="users"
        :headers="headers"
        :search-options="searchParams"
      >
        <template v-slot:item.actions="{ item }">
          <actions :item="item" @actionDeletedResponse="actionDeletedResponse" />
        </template>
      </data-table>
    </base-material-card>
    <checks ref="checksDialog" />
  </v-container>
</template>

<script>
  import Actions from '@/views/dashboard/components/Actions/StaffActions'
  import DataTable from '@/views/dashboard/components/DataTable'
  export default {
    name: 'Staff',
    components: { Actions, DataTable },
    data () {
      return {
        headers: [
          {
            text: 'Имя',
            value: 'first_name',
          },
          {
            text: 'Фамилия',
            value: 'last_name',
          },
          {
            text: 'Аптека',
            value: 'pharmacy.name',
          },
          {
            text: 'Роль',
            value: 'role.name',
          },
          {
            text: 'Электронная почта',
            value: 'email',
          },
          {
            sortable: false,
            text: 'Действия',
            value: 'actions',
            align: 'right',
          },
        ],
        searchParams: {
          name: '',
        },
      }
    },
    methods: {
      openChecksDialog (id) {
        this.$refs.checksDialog.dialog = true
        this.$refs.checksDialog.userId = id
        this.$refs.checksDialog.fetchUserChecks()
      },
      actionDeletedResponse (val) {
        this.items.splice(
          this.items.findIndex(({ id }) => id === val),
          1,
        )
      },
    },
  }
</script>
