<template>
  <v-container
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
    name: 'Create',
    components: {
      FormBase,
    },
    data: () => ({
      schema: [],
      formValue: null,
    }),
    created () {
      this.fetchCheckAttributeForm()
    },
    methods: {
      fetchCheckAttributeForm () {
        this.axios.get('check-attribute-option/create')
          .then(({ data }) => {
            this.schema = data.form
          })
      },
      submit ({ resolve }) {
        this.axios.post('check-attribute-option', this.formValue)
          .then((data) => {
            alert(data)
          })
        resolve()
      },
    },
  }
</script>

<style scoped>

</style>
