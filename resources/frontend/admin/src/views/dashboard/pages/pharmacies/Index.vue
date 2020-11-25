<template>
  <v-container id="extended-tables" fluid tag="section">
    <base-material-card
      color="success"
      icon="mdi-clipboard-text"
      inline
      title="Список аптек с рейтингом"
      class="px-5 py-3 my-6"
    >
      <v-simple-table>
        <thead>
          <tr>
            <th>Название аптеки</th>
            <th>Количество сотрудников</th>
            <th>Адресс аптеки</th>
            <th class="text-right">
              **Действия
            </th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(item, i) in items" :key="i">
            <td v-text="item.name" />
            <td v-text="item.users_count" />
            <td v-if="item.coordinates">
              <a :href="`http://www.google.com/maps/place/${item.coordinates[1]},${item.coordinates[0]}`"
                 target="_blank"
                 v-text="item.address"
              />
            </td>
            <td v-else>
              {{ item.address }}
            </td>

            <td class="text-right">
              <actions :item="item" @actionDeletedResponse="actionDeletedResponse" />
            </td>
          </tr>
        </tbody>
      </v-simple-table>
    </base-material-card>
    <div class="py-3" />
  </v-container>
</template>

<script>
  import can from '@/plugins/directives/v-can'
  import Actions from '@/views/dashboard/components/Actions/PharmacyActions'
  export default {
    name: 'Pharmacy',
    components: { Actions },
    directives: {
      can: can,
    },
    data: () => ({
      items: [],
    }),
    async mounted () {
      const response = await this.$http.get('pharmacies')
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
