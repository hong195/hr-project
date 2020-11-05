<template>
  <v-container id="extended-tables" fluid tag="section">
    <base-material-card
      color="success"
      icon="mdi-clipboard-text"
      inline
      title="Список аптек с рейтингом аптек"
      class="px-5 py-3 my-6"
    >
      <v-simple-table>
        <thead>
          <tr>
            <th>Номер аптеки</th>
            <th>Количество сотрудников</th>
            <th>Рейтинг аптеки</th>
            <th class="text-right">
              **Действия
            </th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(item, i) in pharmacies" :key="i">
            <td v-text="item.number" />
            <td v-text="item.staffNumber" />
            <td v-text="item.rating" />
            <td class="text-right">
              <v-btn
                v-for="(action, i) in actions"
                :key="i"
                v-can="action.can"
                class="px-2 ml-1"
                :color="action.color"
                min-width="0"
                small
              >
                <v-icon small v-text="action.icon" />
              </v-btn>
            </td>
          </tr>
        </tbody>
      </v-simple-table>
    </base-material-card>
    <div class="py-3" />
  </v-container>
</template>

<script>
  import { mapGetters } from 'vuex'
  import can from '@/plugins/directives/v-can'
  export default {
    name: 'DashboardExtendedTables',
    directives: {
      can: can,
    },
    computed: {
      ...mapGetters(['user']),
    },
    data: () => ({
      actions: [
        {
          color: 'info',
          icon: 'mdi-eye',
          can: 'view',
        },
        {
          color: 'success',
          icon: 'mdi-pencil',
          can: 'edit',
        },
        {
          color: 'error',
          icon: 'mdi-close',
          can: 'delete',
        },
      ],
      pharmacies: [
        {
          number: 1,
          staffNumber: 3355,
          rating: 7,
        },
        {
          number: 1,
          staffNumber: 5767,
          rating: 9,
        },
        {
          number: 1,
          staffNumber: 1212,
          rating: 10,
        },
      ],
    }),
  }
</script>
