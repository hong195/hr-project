<template>
  <v-container
    id="regular-forms"
    fluid
    tag="section"
  >
    <base-v-component
      heading="Forms"
      link="components/forms"
    />
    <base-material-card
      color="success"
      icon="mdi-email"
      title="Stacked Form"
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
          name: 'name',
          type: 'text',
          rule: 'required',
          label: 'Имя',
          value: '',
          attributes: {
            dense: true,
            class: 'text-field',
            'open-on-clear': true,
          },
        },
        {
          component: 'text',
          name: 'familyName',
          type: 'text',
          rule: 'required',
          label: 'Фамиля',
          value: '',
          attributes: {
            dense: true,
            class: 'text-field',
            'open-on-clear': true,
          },
        },
        {
          component: 'text',
          name: 'middleName',
          type: 'text',
          rule: 'required',
          label: 'Отчество',
          value: '',
          attributes: {
            dense: true,
            class: 'text-field',
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
          component: 'text',
          name: 'role',
          type: 'text',
          rule: 'required',
          label: 'Роль Сотрудника',
          value: '',
          attributes: {
            dense: true,
            class: 'text-field',
            'open-on-clear': true,
          },
        },
      ],
    }),

    methods: {
      zoomOut () {
        this.zoom = (this.zoom - 10) || 0
      },
      zoomIn () {
        this.zoom = (this.zoom + 10) || 100
      },
      submit ({ resolve }) {
        this.axios.post('http://media-manager.loc/test', this.val)
        resolve()
      },
      test ($event) {
        console.log(this.files)
      },
    },
  }
</script>
