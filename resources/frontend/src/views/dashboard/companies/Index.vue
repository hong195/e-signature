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
        fetch-url="companies"
        :headers="headers"
        :search-options="searchParams"
        mutation="setCompanies"
        getter="companies"
      >
        <template v-slot:item.actions="{ item }">
          <actions
            next-route="update-company"
            fetch-url="companies"
            :item="item"
            mutation="setCompanies"
            getter="companies"
          />
        </template>
      </data-table>
    </base-material-card>
  </v-container>
</template>

<script>
  import DataTable from '@/components/dashboard/DataTable'
  import Actions from '@/components/dashboard/Actions'

  export default {
    name: 'Companies',
    components: { Actions, DataTable },
    data () {
      return {
        headers: [
          {
            text: 'Компания',
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
  }
</script>
