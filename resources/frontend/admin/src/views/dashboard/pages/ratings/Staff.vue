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
          <v-menu
            ref="menu"
            v-model="menu"
            :close-on-content-click="false"
            :return-value.sync="date"
            transition="scale-transition"
            offset-y
            max-width="290px"
            min-width="290px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="date"
                label="Месяц, Год"
                prepend-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
              />
            </template>
            <v-date-picker
              v-model.lazy="date"
              type="month"
              :scrollable="false"
              :locale="locale"
            >
              <v-spacer />
              <v-btn
                text
                color="primary"
                @click="modal = false"
              >
                Отмена
              </v-btn>
              <v-btn
                text
                color="primary"
                @click="setDate(date, $refs.menu)"
              >
                Выбрать
              </v-btn>
            </v-date-picker>
          </v-menu>
        </v-col>
        <v-col cols="12" sm="12" md="3" lg="2">
          <v-select v-model="pharmacy_id" :items="pharmacies" item-text="name" item-value="id" label="Аптека" clearable />
        </v-col>
        <v-col cols="12" sm="12" md="3" lg="2">
          <v-text-field
            v-model="search"
            prepend-icon="mdi-magnify"
            class="ml-auto"
            label="Поиск"
            hide-details
            single-line
          />
        </v-col>
      </v-row>

      <v-divider class="mt-3" />
      <data-table
        ref="data-table"
        fetch-url="user-rating"
        :headers="headers"
        :search-options="searchParams"
      >
        <template v-slot:item.rating="{ item }">
          <tr>
            <td v-if="item.ratings.length">
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

      <!--      <v-data-table-->
      <!--        :headers="headers"-->
      <!--        :items="items"-->
      <!--        :search.sync="search"-->
      <!--        :sort-by="['first_name']"-->
      <!--        :sort-desc="[false, true]"-->
      <!--        :multi-sort="false"-->
      <!--      >-->
      <!--        <template v-slot:item.rating="{ item }">-->
      <!--          <tr>-->
      <!--            <td v-if="item.ratings.length">-->
      <!--              <v-tooltip bottom>-->
      <!--                <template v-slot:activator="{ on, attrs }">-->
      <!--                  <span-->
      <!--                    v-bind="attrs"-->
      <!--                    v-on="on"-->
      <!--                  >-->
      <!--                    <a href="#" @click.prevent="setRating(item.ratings[0])">-->
      <!--                      {{ `${item.ratings[0].scored}/${item.ratings[0].out_of}` }}-->
      <!--                    </a>-->
      <!--                  </span>-->
      <!--                </template>-->
      <!--                <span>Нажмите, чтобы просмотреть подробную информацию о рейтинге</span>-->
      <!--              </v-tooltip>-->
      <!--            </td>-->
      <!--            <td v-else>-->
      <!--              Нет Рейтинга-->
      <!--            </td>-->
      <!--          </tr>-->
      <!--        </template>-->
      <!--      </v-data-table>-->
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

  export default {
    name: 'StaffRating',
    components: { DataTable, SingleUserRating },
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
        pharmacy_id: null,
        // searchParams: {
        //   query_search: '',
        // },
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
      locale () {
        return process.env.VUE_APP_I18N_LOCALE || process.env.VUE_APP_I18N_FALLBACK_LOCALE
      },
      searchParams () {
        const date = moment(this.date ?? null)
        return {
          query_search: this.search,
          year: date.format('YYYY'),
          month: date.format('M'),
          pharmacy_id: this.pharmacy_id,
        }
      },
    },
    watch: {
      // pharmacy_id: {
      //   handler () {
      //     this.fetchUsersWithRating()
      //   },
      // },
      // date: {
      //   handler () {
      //     this.fetchUsersWithRating()
      //   },
      // },
    },
    mounted () {
      this.date = moment().format('YYYY-M')
      // this.fetchUsersWithRating()
      // this.fetchPharmacies()
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
      // fetchPharmacies () {
      //   this.axios.get('pharmacies')
      //     .then(({ data }) => {
      //       this.pharmacies = data.data
      //     })
      // },
      // fetchUsersWithRating () {
      //   const date = moment(this.date ?? null)
      //
      //   this.axios.get('user-rating', {
      //     params: {
      //       year: date.format('YYYY'),
      //       month: date.format('M'),
      //       pharmacy_id: this.pharmacy_id,
      //     },
      //   })
      //     .then(({ data }) => {
      //       this.items = data.data
      //     })
      // },
    },
  }
</script>
