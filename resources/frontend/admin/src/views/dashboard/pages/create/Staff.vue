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
        :loading="isLoading"
        :scope="'test-form'"
        :on-submit="submit"
      />
    </base-material-card>
  </v-container>
</template>

<script>
  import FormBase from '@/components/Form/FormBase'

  export default {
    name: 'CreateStaff',
    components: {
      FormBase,
    },
    data: () => ({
      val: '',
      isLoading: false,
      schema: [],
    }),
    async mounted () {
      this.isLoading = true
      try {
        const response = await this.$http.get('create/user')
        this.schema = response.data.fields
      } catch (e) {
        this.$store.commit('errorMessage', e.data)
        console.log(e)
      }
      this.isLoading = false
    },
    methods: {
      async submit ({ resolve }) {
        this.isLoading = true
        try {
          const response = await this.axios.post('users', this.val)
          this.$store.commit('successMessage', response.data.message)
        } catch (e) {
          this.$store.commit('errorMessage', e)
          console.log(e)
        }
        this.isLoading = false
        resolve()
      },
    },
  }
</script>
