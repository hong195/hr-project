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
        :items="attributes"
        :search.sync="search"
        :sort-by="['id']"
        :sort-desc="[false, true]"
      >
        <template v-slot:item.options="{ item }">
          <tr>
            <td v-for="(option, index) in (item.options)" :key="`index-${option.id}-${index}`">
              {{ option.label }} {{ item.options.length - 1 !== index ? ',' : '' }}
            </td>
          </tr>
        </template>
        <template v-slot:item.type="{ item }">
          <tr>
            <td>{{ item.type === 'radio' ? 'Радио кнопка' : 'Текстовое поле' }}</td>
          </tr>
        </template>
        <template v-slot:item.use_in_rating="{ item }">
          <tr>
            <td>{{ item.use_in_rating ? 'Да' : 'Нет' }}</td>
          </tr>
        </template>
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
      search: null,
      attributes: [],
      headers: [
        {
          text: 'Идентефикатор',
          value: 'id',
        },
        {
          text: 'Тип',
          value: 'type',
        },
        {
          text: 'Название',
          value: 'label',
        },
        {
          text: 'Учитывается при создания рейтинга',
          value: 'use_in_rating',
        },
        {
          text: 'Опции',
          value: 'options',
        },
        {
          text: 'Порядок',
          value: 'order',
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
      this.fetchAttributes()
    },
    methods: {
      actionMethod (method, item) {

      },
      fetchAttributes () {
        this.axios.get('check-attributes')
          .then(({ data }) => {
            this.attributes = data.data
          })
      },
    },
  }
</script>

<style scoped>

</style>
