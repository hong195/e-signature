<template>
  <v-container
    id="regular-forms"
    tag="section"
    class="mt-6"
  >
    <v-card
      light
      class="px-5 py-3 my-10"
    >
      <form-base
        v-model="formValue"
        :schema="schema"
        :scope="'check-create'"
        :method="method"
        :on-submit="createOrUpdate"
        :on-update="createOrUpdate"
      >
        <template slot="actions">
          <v-img height="300" contain src="@/assets/signature-card.jpg" />
          <v-btn color="success">Отправить</v-btn>
        </template>
      </form-base>

    </v-card>
  </v-container>
</template>

<script>
  import { mapGetters } from 'vuex'
  import FormBase from '@/components/Form/FormBase'
  export default {
    name: 'CreateUpdate',
    components: { FormBase },
    data: () => ({
      schema: [

        {
          component: 'text',
          name: 'first_name',
          label: 'Ваше имя (На латинице)',
          value: null,
          rule: 'required',
          attributes: { outlined: true, cols: 6 },
          type: 'text',
          placeholder: null,
        },
        {
          component: 'text',
          name: 'last_name',
          label: 'Ваша Фамилия (На латинице) *',
          value: null,
          rule: 'required',
          attributes: { outlined: true, cols: 6 },
          type: 'text',
          placeholder: null,
        },
        {
          component: 'text',
          name: 'department_id',
          label: 'Ваша должность',
          value: null,
          rule: 'required',
          attributes: { outlined: true, cols: 12 },
          type: 'text',
          placeholder: 'Укажите Вашу должность в соответствии с Орг структурой.',
          hint: 'Укажите Вашу должность в соответствии с Орг структурой.',
        },
        {
          component: 'select',
          name: 'business',
          label: 'Из какого Вы Бизнес Юнита?',
          value: null,
          rule: 'required_if:role,2',
          attributes: { outlined: true, cols: 6 },
          options: [
            { id: 1, name: '\u0410\u043f\u0442\u0435\u043a\u0430 \u211633' },
          ],
        },
        {
          component: 'select',
          name: 'department_id',
          label: 'Департамент',
          value: null,
          rule: 'required_if:role,2',
          attributes: { outlined: true, cols: 6 },
          options: [
            { id: 1, name: '\u0410\u043f\u0442\u0435\u043a\u0430 \u211633' },
          ],
        },
        {
          component: 'text',
          name: 'email',
          label:
            'Укажите Ваш КОРПОРАТИВНЫЙ email. (Если он уже есть)',
          value: null,
          rule: 'required|email',
          attributes: { outlined: true, cols: 6 },
          type: 'email',
          placeholder: 'Необходимо указать Ваш корпоративный email (Яндекс). Обратите внимание что корпоративный email имеет окончание в виде: oxymed.uz; nikapharm.uz; asklepiy.uz и т.д.\n',
          hint: 'Необходимо указать Ваш корпоративный email (Яндекс). Обратите внимание что корпоративный email имеет окончание в виде: oxymed.uz; nikapharm.uz; asklepiy.uz и т.д.\n',
        },
        {
          component: 'text',
          name: 'phoneNumber',
          label:
            'Номер телефона',
          value: null,
          hint: 'Укажите номер телефона в формате 90 999-99-99',
          rule: 'required',
          attributes: { outlined: true, cols: 6 },
          type: 'text',
          placeholder: 'Укажите номер телефона в формате 90 999-99-99',
        },
        {
          component: 'file',
          name: 'file',
          label:
            'Загрузите Вашу фотографию (Данная фотография будет отображаться у Ваших собеседников) *',
          value: null,
          rule: 'required',
          attributes: { outlined: true, cols: 6 },
          type: 'text',
        },
      ],
      formValue: null,
      baseUrl: 'users',
      method: 'post',
    }),
    computed: {
      ...mapGetters('user', ['currentUser']),
      isUpdate () {
        return !!this.$route.params.id
      },
      redirectUrl () {
        if (this.currentUser.role.id === 2) {
          return 'home'
        }
        return 'staff'
      },
    },
    methods: {
      createOrUpdate () {

      },
    },
  }
</script>
