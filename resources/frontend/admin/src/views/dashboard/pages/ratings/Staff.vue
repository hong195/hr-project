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
          <v-select v-model="withRating"
                    :items="showRating"
                    item-text="label"
                    item-value="id"
                    label="Показать"
                    clearable
                    outlined
          />
        </v-col>
        <v-col cols="12" sm="12" md="3" lg="2">
          <v-text-field
            v-model.lazy="search"
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
                    <v-btn :color="getColor(item.ratings[0].scored)"
                           rounded
                           class="rating__btn"
                           depressed
                           @click.prevent="setRating(item.ratings[0])"
                    >
                      {{ `${item.ratings[0].scored}/${item.ratings[0].out_of}` }}
                    </v-btn>
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
      :rating-id="rating.id"
      @close-dialog="closeDialog"
    />
  </v-container>
</template>

<script>
  import moment from 'moment'
  import SingleUserRating from './SingleUserRating'
  import DataTable from '@/views/dashboard/components/DataTable'
  import MonthPicker from '@/views/dashboard/components/MonthPicker'
  import RatingColor from '@/views/dashboard/components/mixins/RatingColor'

  export default {
    name: 'StaffRating',
    components: { DataTable, SingleUserRating, MonthPicker },
    mixins: [RatingColor],
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
        showRating: [
          {
            id: 0,
            label: 'Без рейтинга',
          },
          {
            id: 1,
            label: 'С рейтингом',
          },
        ],
        withRating: null,
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
          withRating: this.withRating,
        }
      },
    },
    mounted () {
      this.fetchPharmacies()
      if (this.$route.query.rating_id) {
        this.rating = {}
        this.rating.id = parseInt(this.$route.query.rating_id)
        this.dialog = true
      }
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
        this.axios.get('pharmacies', {
          params: {
            perPage: 100000,
          },
        })
          .then(({ data }) => {
            this.pharmacies = data.data
          })
      },
    },
  }
</script>
<style lang="scss">
.rating {
  &__btn {
    & .v-btn__content {
      color: #fff;
    }
  }
}
</style>
