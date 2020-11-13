<template>
  <div>
    <v-btn
      v-for="(action, i) in actions"
      :key="i"
      dark
      class="px-2 ml-1"
      :color="action.color"
      min-width="0"
      small
      @click="actionMethod(action.method)"
    >
      <v-icon small v-text="action.icon" />
    </v-btn>
  </div>
</template>

<script>
  export default {
    name: 'Actions',
    props: ['item'],
    data () {
      return {
        activeItem: {},
        actions: [
          {
            color: 'success',
            icon: 'mdi-pencil',
            can: 'edit',
            method: 'editItem',
          },
          {
            color: 'error',
            icon: 'mdi-close',
            can: 'delete',
            method: 'deleteItem',
          },
        ],
      }
    },
    methods: {
      actionMethod (funcName, item) {
        this[funcName](item)
      },
      editItem () {
        this.$router.push({
          name: 'createPharmacy',
          query: { edit: true, id: this.item.id },
        })
      },
      deleteItem () {
        this.$http
          .delete(`pharmacies/${this.item.id}`)
          .then((response) => {
            this.$emit('actionDeletedResponse', this.item.id)
            this.$store.commit('successMessage', response.data.message)
          })
          .catch(error => {
            console.error(error)
            this.$store.commit('errorMessage', error)
          })
      },
    },
  }
</script>
