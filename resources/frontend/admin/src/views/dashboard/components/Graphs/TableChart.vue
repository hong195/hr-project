<template>
  <div>
    <div class="d-flex">
      <v-spacer />
      <v-btn outlined small class="mr-3" @click="sortRatings">
        Сортировать рейтинги <v-icon>
          {{ asc ? 'mdi-menu-up' : 'mdi-menu-down' }}
        </v-icon>
      </v-btn>
      <export-to-pdf :excel-data="excelData"
                     :headers-pdf="headersPdf"
      />
    </div>
    <v-data-table
      :items="items"
      :headers="headers"
      :loading="isLoading"
      :disable-sort="true"
    >
      <template v-slot:item.rating="{ item }">
        <tr>
          <td v-if="item.rating.scored">
            <v-btn :color="getColor(item.rating.scored)"
                   rounded
                   class="rating__btn"
                   depressed
                   @click="getRating(item.rating.id)"
            >
              <span style="color: white;">{{ `${item.rating.scored}/${item.rating.out_of}` }}</span>
            </v-btn>
          </td>
          <td v-else>
            Нет Рейтинга
          </td>
        </tr>
      </template>
    </v-data-table>
    <single-user-rating
      :show-dialog="dialog"
      :rating-id="ratingId"
      @close-dialog="dialog = false"
    />
  </div>
</template>

<script>
  import RatingColor from '@/views/dashboard/components/mixins/RatingColor'
  import SingleUserRating from '@/views/dashboard/pages/ratings/SingleUserRating'
  import ExportToPdf from '@/views/dashboard/components/ExportToPdf'
  export default {
    name: 'TableChart',
    components: { ExportToPdf, SingleUserRating },
    mixins: [RatingColor],
    props: {
      items: {
        type: Array,
        default: () => ([]),
      },
      isLoading: {
        type: Boolean,
      },
    },
    data () {
      return {
        asc: 0,
        dialog: false,
        ratingId: null,
        headers: [
          {
            text: 'Аптека',
            value: 'name',
          },
          {
            text: 'Рейтинг',
            value: 'rating',
          },
        ],
        headersPdf: {
          '№': 'index',
          Аптека: 'name',
          Рейтинг: {
            field: 'rating',
            callback: (value) => {
              if (value) { return value.scored } else return 'Нет Рейтинга'
            },
          },
          Общий: 'rating.out_of',
        },
      }
    },
    computed: {
      excelData () {
        var copy = this.items
        let i = 1
        copy.forEach((item) => {
          item.index = i
          i++
        })
        return copy
      },
    },
    methods: {
      sortRatings () {
        this.asc = this.asc ? 0 : 1
        if (this.asc === 0) {
          this.items = this.items.sort((a, b) => (a.rating.scored > b.rating.scored) ? 1 : ((b.rating.scored > a.rating.scored) ? -1 : 0))
        } else {
          this.items = this.items.sort((a, b) => (a.rating.scored < b.rating.scored) ? 1 : ((b.rating.scored < a.rating.scored) ? -1 : 0))
        }
      },
      getRating (ratingId) {
        this.ratingId = ratingId
        this.dialog = true
      },
    },
  }
</script>
