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
      title="Создание чека"
      class="px-5 py-3 mb-10"
    >
      {{ formValue }}
      <form-base
        v-model="formValue"
        :schema="schema"
        :scope="'check-create'"
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
      schema: [],
      formValue: null,
    }),
    created () {
      this.fetchCheckForm()
    },
    methods: {
      fetchCheckForm () {
        this.axios.get('checks/create')
          .then(({ data }) => {
            this.schema = data.form
          })
      },
      submit () {

      },
    },
  }
</script>
