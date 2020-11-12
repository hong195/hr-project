<template>
  <v-container id="extended-tables" fluid tag="section">
    <base-material-card
      color="success"
      icon="mdi-clipboard-text"
      inline
      title="Список чеков"
      class="px-5 py-3 my-6"
    >
      <v-data-table
        :headers="headers"
        :items="checks"
        :search.sync="search"
        :sort-by="['id']"
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
      checks: [],
      search: null,
      headers: [
        {
          text: 'Идентефикатор',
          value: 'id',
        },
        {
          text: 'Поьзователь',
          value: 'owner',
        },
        {
          text: 'Дата созданя',
          value: 'created_at',
        },
        {
          sortable: false,
          text: 'Actions',
          value: 'actions',
          align: 'right',
        },
      ],
      actions: [
        {
          color: 'info',
          icon: 'mdi-eye',
          can: 'view',
          method: 'viewItem',
        },
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
      this.fetchChecks()
    },
    methods: {
      fetchChecks () {
        this.axios.get('checks', {
          params: {
            with_user: true,
          },
        })
          .then(({ data }) => {
            this.checks = data.data.map(check => {
              return {
                ...check,
                owner: `${check.user.first_name} ${check.user.last_name} ${check.user.patronymic}`,
              }
            })
          })
      },
      actionMethod (funcName, item) {
        this[funcName](item)
      },
      deleteItem (item) {
        this.axios.delete(`checks/${item.id}`)
          .then(() => {
            this.checks.splice(
              this.checks.findIndex(({ id }) => id === item.id), 1,
            )
          })
          .catch(error => {
            console.error(error)
          })
      },
    },
  }
</script>

<style scoped>

</style>
