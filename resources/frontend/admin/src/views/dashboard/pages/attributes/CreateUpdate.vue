<template>
  <v-container
    fluid
    tag="section"
    class="mt-3"
  >
    <default-form :base-url="baseUrl"
                  title-create="Создать опцию"
                  title-update="Создать атрибут"
    />
  </v-container>
</template>
<script>
  import DefaultForm from '@/views/dashboard/components/DefaultForm'
  export default {
    name: 'Create',
    components: {
      DefaultForm,
    },
    data: () => ({
      schema: [],
      formValue: null,
      baseUrl: 'check-attributes',
    }),
    computed: {
      isUpdate () {
        return !!this.$route.params.id
      },
    },
  }
</script>

<style scoped>

</style>
