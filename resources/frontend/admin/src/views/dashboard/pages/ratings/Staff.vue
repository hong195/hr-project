<template>
  <v-container id="data-tables" tag="section">
    <base-v-component heading="Рейтинг сотрудников" />
    <base-material-card
      color="indigo"
      icon="mdi-vuetify"
      inline
      class="px-5 py-3"
    >
      <template v-slot:after-heading>
        <div class="display-2 font-weight-light">
          Список сотрудников
        </div>
      </template>

      <v-row justify="end">
        <v-col cols="12" sm="12" md="3" lg="2">
          <month-picker v-model="date" />
        </v-col>
        <v-col cols="12" sm="12" md="3" lg="2">
          <v-select v-model="pharmacyId"
                    :items="pharmacies"
                    item-text="name"
                    item-value="id"
                    label="Аптека"
                    clearable
                    outlined
          />
        </v-col>
        <v-col cols="12" sm="12" md="3" lg="2">
          <v-text-field
            v-model="search"
            class="ml-auto"
            label="Поиск"
            single-line
            outlined
          />
        </v-col>
      </v-row>

      <v-divider class="mt-3" />
      <data-table
        v-if="date"
        ref="data-table"
        fetch-url="user-rating"
        :headers="headers"
        :search-options="searchParams"
      >
        <template v-slot:item.rating="{ item }">
          <tr>
            <td v-if="item.ratings && item.ratings.length">
              <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                  <span
                    v-bind="attrs"
                    v-on="on"
                  >
                    <a href="#" @click.prevent="setRating(item.ratings[0])">
                      {{ `${item.ratings[0].scored}/${item.ratings[0].out_of}` }}
                    </a>
                  </span>
                </template>
                <span>Нажмите, чтобы просмотреть подробную информацию о рейтинге</span>
              </v-tooltip>
            </td>
            <td v-else>
              Нет Рейтинга
            </td>
          </tr>
        </template>
      </data-table>
    </base-material-card>

    <single-user-rating
      :show-dialog="dialog"
      :rating="rating"
      @close-dialog="closeDialog"
    />
  </v-container>
</template>

<script>
  import moment from 'moment'
  import SingleUserRating from './SingleUserRating'
  import DataTable from '@/views/dashboard/components/DataTable'
  import MonthPicker from '@/views/dashboard/components/MonthPicker'

  export default {
    name: 'StaffRating',
    components: { DataTable, SingleUserRating, MonthPicker },
    data () {
      return {
        date: null,
        menu: false,
        dialog: false,
        items: [],
        search: undefined,
        checks: [],
        rating: {},
        pharmacies: [],
        pharmacyId: null,
        headers: [
          {
            text: 'Фамилия',
            value: 'last_name',
          },
          {
            text: 'Имя',
            value: 'first_name',
          },
          {
            text: 'Отчество',
            value: 'patronymic',
          },
          {
            text: 'Электронная почта',
            value: 'email',
          },
          {
            sortable: false,
            text: 'Рейтинг',
            value: 'rating',
          },
        ],
      }
    },
    computed: {
      searchParams () {
        const date = moment(this.date)
        return {
          name: this.search,
          ratingYear: date.format('YYYY'),
          ratingMonth: date.format('M'),
          pharmacyId: this.pharmacyId,
        }
      },
    },
    mounted () {
      this.fetchPharmacies()
    },

    methods: {
      closeDialog () {
        this.dialog = false
      },
      setRating (rating) {
        this.dialog = true
        this.rating = rating
      },
      setDate (date, dialog) {
        dialog.save(date)
        this.date = date
      },
      fetchPharmacies () {
        this.axios.get('pharmacies')
          .then(({ data }) => {
            this.pharmacies = data.data
          })
      },
    },
  }
</script>
