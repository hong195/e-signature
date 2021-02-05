<template>
  <v-container
    id="regular-forms"
    tag="section"
    class="mt-6"
  >
    <v-card
      light
      class="px-5 py-5 my-10"
      max-width="768"
      style="margin: auto"
    >
      <v-img width="100%" contain height="160px" src="@/assets/formLogo.png" />
    </v-card>
    <v-card
      light
      class="px-5 py-5 my-10"
      max-width="768"
      style="margin: auto"
    >
      <p style="font-size: 32px;">
        Форма для создания электронной почты и подписи.
      </p>
      <p>
        Данная форма используется для отправки заявки на создание электронной почты с корпоративной подписью.
      </p>
      <p>
        Когда вы загрузите файлы и отправите форму, мы сохраним ваше имя и фото профиля.
      </p>
    </v-card>
    <v-card
      light
      class="px-5 py-5 my-10"
      max-width="768"
      style="margin: auto"
    >
      <validation-observer ref="obs" v-slot="{ handleSubmit }">
        <v-form @submit.prevent="handleSubmit(handle)">
          <v-row>
            <v-col cols="6">
              <validation-provider
                v-slot="{ errors }"
                tag="div"
                :rules="schema.first_name.rule"
                :name="schema.first_name.label"
                :vid="schema.first_name.name"
              >
                <v-text-field
                  v-model="schema.first_name.value"
                  :error-messages="errors"
                  :name="schema.first_name.name"
                  v-bind="schema.first_name.attributes"
                  :label="schema.first_name.label"
                />
              </validation-provider>
            </v-col>
            <v-col cols="6">
              <validation-provider
                v-slot="{ errors }"
                tag="div"
                :rules="schema.last_name.rule"
                :name="schema.last_name.label"
                :vid="schema.last_name.name"
              >
                <v-text-field
                  v-model="schema.last_name.value"
                  :error-messages="errors"
                  :name="schema.last_name.name"
                  v-bind="schema.last_name.attributes"
                  :label="schema.last_name.label"
                />
              </validation-provider>
            </v-col>
            <v-col cols="6">
              <validation-provider
                v-slot="{ errors }"
                tag="div"
                :rules="schema.position.rule"
                :name="schema.position.label"
                :vid="schema.position.name"
              >
                <v-text-field
                  v-model="schema.position.value"
                  :error-messages="errors"
                  :name="schema.position.name"
                  v-bind="schema.position.attributes"
                  :label="schema.position.label"
                />
              </validation-provider>
            </v-col>
            <v-col cols="6">
              <validation-provider
                v-slot="{ errors }"
                tag="div"
                :rules="schema.business_id.rule"
                :name="schema.business_id.label"
                :vid="schema.business_id.name"
              >
                <v-select
                  v-model="schema.business_id.value"
                  v-bind="schema.business_id.attributes"
                  :error-messages="errors"
                  :label="schema.business_id.label"
                  :items="schema.business_id.options"
                  item-text="name"
                  item-value="id"
                  @change="filterDepartments"
                />
              </validation-provider>
            </v-col>
            <v-col cols="6">
              <validation-provider
                v-slot="{ errors }"
                tag="div"
                :rules="schema.department_id.rule"
                :name="schema.department_id.label"
                :vid="schema.department_id.name"
              >
                <v-select
                  v-model="schema.department_id.value"
                  v-bind="schema.department_id.attributes"
                  :error-messages="errors"
                  :label="schema.department_id.label"
                  :items="schema.department_id.options"
                  item-text="name"
                  item-value="id"
                />
              </validation-provider>
            </v-col>
            <v-col cols="6">
              <validation-provider
                v-slot="{ errors }"
                tag="div"
                :rules="schema.email.rule"
                :name="schema.email.label"
                :vid="schema.email.name"
              >
                <v-text-field
                  v-model="schema.email.value"
                  :error-messages="errors"
                  :name="schema.email.name"
                  v-bind="schema.email.attributes"
                  :label="schema.email.label"
                />
              </validation-provider>
            </v-col>
            <v-col cols="12">
              {{ schema.phone.label }}
              <validation-provider
                v-slot="{ errors }"
                tag="div"
                :name="schema.phone.label"
                :rules="schema.phone.rule"
                :vid="schema.phone.name"
              >
                <v-text-field
                  v-model="schema.phone.value"
                  v-mask="'## ### ## ##'"
                  :error-messages="errors"
                  :name="schema.phone.name"
                  v-bind="schema.phone.attributes"
                  placeholder="-- --- -- --"
                  solo
                  outlined
                  flat
                >
                  <template slot="prepend-inner" class="inner-text">
                    +998
                  </template>
                </v-text-field>
              </validation-provider>
            </v-col>
            <v-col cols="12">
              <application-preview :url="url" :schema="schema" />
            </v-col>
            <v-col cols="12">
              <validation-provider
                v-slot="{ errors }"
                tag="div"
                :rules="schema.file.rule"
                :name="schema.file.label"
                :vid="schema.file.name"
              >
                <v-file-input
                  v-model="schema.file.value"
                  :error-messages="errors"
                  :name="schema.file.name"
                  v-bind="schema.file.attributes"
                  :label="schema.file.label"
                  accept="image/*"
                  @change="fileChange"
                />
              </validation-provider>
            </v-col>
            <v-col cols="12" class="text-center">
              <v-btn type="submit" color="success">
                Отправить
              </v-btn>
            </v-col>
          </v-row>
        </v-form>
      </validation-observer>
    </v-card>
  </v-container>
</template>

<script>
  import { mapGetters } from 'vuex'
  import { ValidationObserver } from 'vee-validate'
  import ApplicationPreview from '@/components/pages/ApplicationPreview'
  import { mask } from 'vue-the-mask'
  export default {
    name: 'CreateUpdate',
    components: { ApplicationPreview, ValidationObserver },
    directives: { mask },
    data: () => ({
      departments: [
        { id: 1, name: 'd-1', business_id: 1 },
        { id: 2, name: 'd-2', business_id: 2 },
        { id: 3, name: 'd-3', business_id: 3 },
      ],
      url: null,
      schema: {
        first_name: {
          component: 'text',
          name: 'name',
          label: 'Ваше имя (На латинице)',
          value: null,
          rule: 'required',
          attributes: { outlined: true },
          type: 'text',
          placeholder: null,
        },
        last_name:
          {
            component: 'text',
            name: 'surname',
            label: 'Ваша Фамилия (На латинице)',
            value: null,
            rule: 'required',
            attributes: { outlined: true },
            type: 'text',
            placeholder: null,
          },
        position: {
          component: 'text',
          name: 'position',
          label: 'Ваша должность',
          value: null,
          rule: 'required',
          attributes: { outlined: true, cols: 12 },
          type: 'text',
          placeholder: 'Укажите Вашу должность в соответствии с Орг структурой.',
          hint: 'Укажите Вашу должность в соответствии с Орг структурой.',
        },
        business_id: {
          component: 'select',
          name: 'business',
          label: 'Из какого Вы Бизнес Юнита?',
          value: null,
          rule: 'required',
          attributes: { outlined: true },
          options: [
            { id: 1, name: 'a-1' },
            { id: 2, name: 'a-2' },
            { id: 3, name: 'a-3' },
          ],
        },
        department_id: {
          component: 'select',
          name: 'department_id',
          label: 'Департамент',
          value: null,
          rule: 'required',
          attributes: { outlined: true },
          options: [
            { id: 1, name: 'd-1', business_id: 1 },
            { id: 2, name: 'd-2', business_id: 2 },
            { id: 3, name: 'd-3', business_id: 3 },
          ],
        },
        email: {
          component: 'text',
          name: 'email',
          label:
            'Ваш E-mail',
          value: null,
          rule: 'required|email',
          attributes: { outlined: true },
          type: 'email',
          placeholder: 'Необходимо указать Ваш корпоративный email (Яндекс). Обратите внимание что корпоративный email имеет окончание в виде: oxymed.uz; nikapharm.uz; asklepiy.uz и т.д.\n',
          hint: 'Необходимо указать Ваш корпоративный email (Яндекс). Обратите внимание что корпоративный email имеет окончание в виде: oxymed.uz; nikapharm.uz; asklepiy.uz и т.д.\n',
        },
        phone: {
          component: 'text',
          name: 'phone',
          label:
            'Номер телефона',
          value: '',
          hint: 'Укажите номер телефона в формате 90 999-99-99',
          rule: 'required|min:12',
          attributes: { outlined: true },
          type: 'text',
          placeholder: 'Укажите номер телефона в формате 90 999-99-99',
        },
        file: {
          component: 'file',
          name: 'file',
          label:
            'Загрузите Вашу фотографию (Данная фотография будет отображаться у Ваших собеседников) *',
          value: null,
          rule: 'required',
          type: 'text',
        },
      },
      formValue: null,
      baseUrl: 'users',
      method: 'post',
    }),
    computed: {
      phoneToSend () {
        if (this.schema.phone.value.length === 12) { return '+998' + this.schema.phone.value.replace(/ /g, '') } else { return null }
      },
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
      filterDepartments (val) {
        this.schema.department_id.options = this.departments.filter(item => item.business_id === val)
      },
      fileChange (val) {
        console.log(val)
        this.url = URL.createObjectURL(val)
      },
      handle () {
        const formData = new FormData()
        Object.values(this.schema).forEach((item) => {
          if (item.name === 'phone') {
            formData.append(item.name, this.phoneToSend)
          } else { formData.append(item.name, item.value) }
        })
        this.$http.post('', formData)
      },
    },
  }
</script>
