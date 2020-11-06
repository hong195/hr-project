<template>
  <v-container id="data-tables" tag="section">
    <base-v-component heading="Data Tables" link="components/data-tables" />
    <base-material-card
      color="indigo"
      icon="mdi-vuetify"
      inline
      class="px-5 py-3"
    >
      <template v-slot:after-heading>
        <div class="display-2 font-weight-light">
          DataTables
        </div>
      </template>

      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        class="ml-auto"
        label="Search"
        hide-details
        single-line
        style="max-width: 250px"
      />

      <v-divider class="mt-3" />

      <v-data-table
        :headers="headers"
        :items="items"
        :search.sync="search"
        :sort-by="['name', 'office']"
        :sort-desc="[false, true]"
        multi-sort
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
  </v-container>
</template>

<script>
  export default {
    name: 'DashboardDataTables',
    data () {
      return {
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
        headers: [
          {
            text: 'First Name',
            value: 'first_name',
          },
          {
            text: 'Last Name',
            value: 'last_name',
          },
          {
            text: 'Name',
            value: 'email',
          },
          {
            sortable: false,
            text: 'Actions',
            value: 'actions',
            align: 'right',
          },
        ],
        items: [],
        search: undefined,
      }
    },
    async mounted () {
      const response = await this.$http.get('users')
      this.items = response.data.data
    },
    methods: {
      actionMethod (funcName, item) {
        this[funcName](item)
      },
      editItem (item) {
        this.$router.push({
          name: 'post_edit',
          query: { edit: true, id: item.id },
        })
      },
      viewItem (item) {
        console.log(item)
        this.activeItem = item
        this.dialog = true
      },
      deleteItem (item) {
        this.$http
          .delete(`users/${item.id}`)
          .then(() => {
            this.items.splice(
              this.items.findIndex(({ id }) => id === item.id),
              1,
            )
          })
          .catch(error => {
            console.error(error)
          })
      },
    },
  }
</script>
