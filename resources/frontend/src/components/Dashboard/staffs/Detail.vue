<template>
  <v-dialog
    v-model="dialog"
    max-width="500px"
  >
    <v-card>
      <v-card-title>
        <span class="display-2">Информация о персонале</span>
        <v-spacer />
        <v-icon @click="dialog=false">
          mdi-close
        </v-icon>
      </v-card-title>
      <v-card-text>
        <table class="table-detail">
          <tr>
            <td>
              Ф.И.О
            </td>
            <td>
              {{ item.name }} {{ item.surname }}
            </td>
          </tr>
          <tr>
            <td>
              Должность
            </td>
            <td>
              {{ item.position }}
            </td>
          </tr>
          <tr>
            <td>
              Электронная почта
            </td>
            <td>
              {{ item.email }}
            </td>
          </tr>
          <tr>
            <td>
              Номер телефона
            </td>
            <td>
              {{ item.phone }}
            </td>
          </tr>
        </table>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
  export default {
    name: 'StaffDetail',
    props: ['item'],
    data () {
      return {
        dialog: false,
      }
    },
  }
</script>
<style lang="scss">
.table-detail{
  width: 100%;
  td{
    padding: 10px 0;
    border-bottom: 1px solid #c5c5c5;
    span.meta{
      color: rgba(0, 0, 0, 0.6);
    }
  }
  td:nth-child(2){
    color: #1a1a1a;
    font-size: 16px;
  }
  tr:last-child{
    td{
      border-bottom: none;
    }
  }
}
</style>
