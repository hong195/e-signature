<template>
  <v-container
    id="regular-forms"
    fluid
    tag="section"
    class="mt-3"
  >
    <default-form :base-url="baseUrl"
                  next-route-name="department"
                  title-create="Добавить отдел"
                  title-update="Редактировать отдел"
    />
  </v-container>
</template>

<script>
  import DefaultForm from '@/views/dashboard/components/DefaultForm'
  export default {
    name: 'CreateUpdate',
    components: {
      DefaultForm,
    },
    data: () => ({
      schema: [],
      formValue: null,
      baseUrl: 'departments',
    }),
  }
</script>
