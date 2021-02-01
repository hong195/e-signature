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
          v-model.lazy="searchParams.qs"
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
        fetch-url="departments"
        :headers="headers"
        :search-options="searchParams"
        mutation="setDepartments"
        getter="departments"
      />
    </base-material-card>
  </v-container>
</template>

<script>
  import DataTable from '@/views/dashboard/components/DataTable'

  export default {
    name: 'Departments',
    components: { DataTable },
    data () {
      return {
        headers: [
          {
            text: 'Департамент',
            value: 'name',
          },
          {
            sortable: false,
            text: 'Действия',
            value: 'actions',
            align: 'right',
          },
        ],
        searchParams: {
          qs: '',
        },
      }
    },
    methods: {
      actionDeletedResponse (val) {
        this.items.splice(
          this.items.findIndex(({ id }) => id === val),
          1,
        )
      },
    },
  }
</script>
