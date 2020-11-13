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
      :title="$route.query.edit ? $t('edit_info') : 'Создать аптеку'"
      class="px-5 py-3 mb-10"
    >
      <form-base
        v-model="val"
        :schema="schema"
        :method="method"
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
    name: 'CreatePharmacy',
    components: {
      FormBase,
    },
    data: () => ({
      val: '',
      isLoading: false,
      schema: [],
      method: 'post',
      url: 'pharmacies',
    }),
    async mounted () {
      let url = 'pharmacies/create'
      if (this.$route.query.edit) {
        this.method = 'put'
        this.url = `pharmacies/${this.$route.query.id}`
        url = `pharmacies/${this.$route.query.id}/edit`
      }
      await this.createForm(url)
    },
    methods: {
      async createForm (url) {
        this.isLoading = true
        try {
          const response = await this.$http.get(url)
          this.schema = response.data
        } catch (e) {
          this.$store.commit('errorMessage', e.data)
        }
        this.isLoading = false
      },
      async submit ({ resolve }) {
        this.isLoading = true
        try {
          const response = await this.axios[this.method](this.url, this.val)
          this.$store.commit('successMessage', response.data.message)
          this.$router.push({ name: 'pharmacy' })
        } catch (e) {
          this.$store.commit('errorMessage', e)
        }
        this.isLoading = false
        resolve()
      },
    },
  }
</script>
