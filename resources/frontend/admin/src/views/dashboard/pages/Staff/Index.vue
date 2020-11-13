<template>
  <v-container id="data-tables" tag="section">
    <base-material-card
      color="indigo"
      icon="mdi-account-multiple"
      inline
      class="px-5 py-3 mt-6"
    >
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
          <actions :item="item" @actionDeletedResponse="actionDeletedResponse" />
        </template>
      </v-data-table>
    </base-material-card>
  </v-container>
</template>

<script>
  import Actions from '@/views/dashboard/components/Actions/StaffActions'
  export default {
    name: 'Staff',
    components: { Actions },
    data () {
      return {
        headers: [
          {
            text: 'Имя',
            value: 'first_name',
          },
          {
            text: 'Фамилия',
            value: 'last_name',
          },
          {
            text: 'Аптека',
            value: 'pharmacy',
          },
          {
            text: 'Роль',
            value: 'role.name',
          },
          {
            text: 'Электронная почта',
            value: 'email',
          },
          {
            sortable: false,
            text: 'Действия',
            value: 'actions',
            align: 'right',
          },
        ],
        items: [],
        search: null,
      }
    },
    async mounted () {
      const response = await this.$http.get('users')
      this.items = response.data.data
    },
    methods: {
      actionDeletedResponse (val) {
        this.items.splice(
          this.items.findIndex(({ id }) => id === val),
          1,
        )
      },
    },
  }
</script>
