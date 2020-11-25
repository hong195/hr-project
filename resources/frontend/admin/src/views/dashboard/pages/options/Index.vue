<template>
  <v-container id="extended-tables" fluid tag="section">
    <base-material-card
      color="success"
      icon="mdi-clipboard-text"
      inline
      title="Список Атрибутов"
      class="px-5 py-3 my-6"
    >
      <v-data-table
        :headers="headers"
        :items="options"
        :search.sync="search"
        :sort-desc="[false, true]"
      >
        <template v-slot:item.actions="{ item }">
          <v-btn
            v-for="(action, i) in actions"
            :key="i"
            class="px-2 ml-1"
            :color="action.color"
            min-width="0"
            small
            @click="actionMethod(action.method, item)"
          >
            <v-icon small v-text="action.icon" />
          </v-btn>
        </template>
      </v-data-table>
    </base-material-card>
    <div class="py-3" />
  </v-container>
</template>

<script>
  export default {
    name: 'Index',
    data: () => ({
      options: [],
      search: null,
      dialog: false,
      activeItem: null,
      headers: [
        {
          text: 'Идентефикатор',
          value: 'id',
        },
        {
          text: 'Название',
          value: 'label',
        },
        {
          text: 'Слаг',
          value: 'name',
        },
        {
          text: 'Атрибут',
          value: 'attribute.label',
        },
        {
          text: 'Значение',
          value: 'value',
        },
        {
          sortable: false,
          text: 'Действия',
          value: 'actions',
          align: 'right',
        },
      ],
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
    }),
    created () {
      this.fetchOptions()
    },
    methods: {
      actionMethod (funcName, item) {
        this[funcName](item)
      },
      fetchOptions () {
        this.axios.get('check-attribute-option')
          .then(({ data }) => {
            this.options = data.data
          })
      },
      editItem (item) {
        this.$router.push({ name: 'update-attribute-options', params: { id: item.id } })
      },
      deleteItem (item) {
        this.axios.delete(`check-attribute-option/${item.id}`)
          .then(({ data }) => {
            this.fetchOptions()
            this.$store.commit('successMessage', data.message)
          })
          .catch(error => {
            this.$store.commit('errorMessage', error)
          })
      },
    },
  }
</script>

<style scoped>

</style>
