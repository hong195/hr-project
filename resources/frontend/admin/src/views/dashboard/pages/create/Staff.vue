<template>
  <v-container
    id="regular-forms"
    fluid
    tag="section"
    class="mt-3"
  >
    <base-material-card
      color="success"
      icon="mdi-account"
      title="Добавить сотрудника"
      class="px-5 py-3 mb-10"
    >
      <form-base
        v-model="val"
        :schema="schema"
        :scope="'test-form'"
        :on-submit="submit"
      />
    </base-material-card>
  </v-container>
</template>

<script>
  import FormBase from '@/components/Form/FormBase'

  export default {
    name: 'DashboardFormsRegularForms',
    components: {
      FormBase,
    },
    data: () => ({
      checkbox: true,
      items: ['Foo', 'Bar', 'Fizz', 'Buzz'],
      radioGroup: 1,
      switch1: true,
      zoom: 0,
      val: '',
      files: 'null',
      schema: [
        {
          component: 'text',
          name: 'first_name',
          type: 'text',
          rule: 'required',
          label: 'Имя',
          value: '',
          attributes: {
            outlined: true,
            class: 'text-field',
            'open-on-clear': true,
          },
        },
        {
          component: 'text',
          name: 'last_name',
          type: 'text',
          rule: 'required',
          label: 'Фамиля',
          value: '',
          attributes: {
            outlined: true,
            class: 'text-field',
            'open-on-clear': true,
          },
        },
        {
          component: 'text',
          name: 'patronymic',
          type: 'text',
          rule: 'required',
          label: 'Отчество',
          value: '',
          attributes: {
            outlined: true,
            class: 'text-field',
            'open-on-clear': true,
          },
        },
        {
          component: 'birthday',
          name: 'birthday',
          type: 'text',
          rule: 'required',
          label: 'Дата рождения',
          value: '',
          attributes: {
            outlined: true,
            class: 'birthday-field',
            'open-on-clear': true,
          },
        },
        {
          component: 'select',
          label: 'Пол сотрудника',
          attributes: {
            outlined: true,
            class: 'select-field',
            'open-on-clear': true,
          },
          name: 'gender',
          rule: 'required',
          cols: '6',
          value: '',
          options: [
            {
              id: '1',
              name: 'Мужской',
            },
            {
              id: '2',
              name: 'Женский',
            },
          ],
        },
        {
          component: 'select',
          name: 'role',
          rule: 'required',
          label: 'Роль Сотрудника',
          cols: '6',
          value: '',
          options: [],
          attributes: {
            outlined: true,
            class: 'text-field',
            'open-on-clear': true,
          },
        },
      ],
    }),
    async mounted () {
      // this.fetchRoles()
      const response = await this.$http.get('create/user')
      this.schema = response.data.fields

    // 'pharmacy_id' => ['exists:pharmacies,id'],
    //   'first_name' => ['required', 'alpha'],
    //   'last_name' => ['required', 'alpha'],
    //   'patronymic' => ['required', 'alpha'],
    //   'email' => ['required', 'email', 'unique:users,email'],
    //   'password' => ['required', 'min:6', 'alpha_dash'],
    //   'role' => ['required', 'exists:roles,id'],
    //   'meta.gender' => ['nullable'],
    //   'meta.birthday' => ['date', 'nullable'],
    },

    methods: {
      fetchRoles () {
        this.$http.get('roles')
          .then(({ data }) => {
            const roles = this.schema.find((el) => el.name === 'role')
            roles.options = data.data
          })
      },
      submit ({ resolve }) {
        this.axios.post('http://media-manager.loc/test', this.val)
        resolve()
      },
    },
  }
</script>
