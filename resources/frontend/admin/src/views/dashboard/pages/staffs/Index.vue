<template>
  <v-container id="data-tables" tag="section">
    <base-material-card
      color="indigo"
      icon="mdi-account-multiple"
      inline
      class="px-5 py-3 mt-6"
    >
      <div class="d-flex">
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          class="ml-auto mr-3"
          label="Search"
          hide-details
          single-line
          outlined
          large
          style="max-width: 250px"
        />
        <v-btn :to="{name: 'create-checks'}" x-large outlined
               color="success"
        >
          Создать чек
        </v-btn>
      </div>

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
        <template v-slot:item.check="{ item }">
          <v-btn color="info" outlined @click="openChecksDialog(item.id)">
            Чек
          </v-btn>
        </template>
      </v-data-table>
    </base-material-card>
    <checks ref="checksDialog" />
  </v-container>
</template>

<script>
  import Actions from '@/views/dashboard/components/Actions/StaffActions'
  import Checks from '@/views/dashboard/pages/staffs/Checks'
  export default {
    name: 'Staff',
    components: { Checks, Actions },
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
            value: 'pharmacy.name',
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
            text: 'Чек',
            value: 'check',
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
      openChecksDialog (id) {
        this.$refs.checksDialog.dialog = true
        this.$refs.checksDialog.userId = id
        this.$refs.checksDialog.fetchUserChecks()
      },
      actionDeletedResponse (val) {
        this.items.splice(
          this.items.findIndex(({ id }) => id === val),
          1,
        )
      },
    },
  }
</script>
