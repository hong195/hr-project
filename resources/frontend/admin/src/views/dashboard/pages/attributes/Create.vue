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
        :schema="formSchema"
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
    computed: {
      formSchema () {
        if (!this.schema.length) {
          return []
        }

        if (this.formValue && this.formValue.type !== 'textarea') {
          return this.schema
        }

        return this.schema.filter(field => {
          return field.name !== 'use_in_rating'
        })
      },
    },
    created () {
      this.fetchCheckForm()
    },
    methods: {
      fetchCheckForm () {
        this.axios.get('check-attributes/create')
          .then(({ data }) => {
            this.schema = data.form
          })
      },
      submit () {

      },
    },
  }
</script>

<style scoped>

</style>
