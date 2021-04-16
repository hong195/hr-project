<template>
  <div>
    <div class="d-flex">
      <v-spacer />
      <v-btn outlined large class="mr-3" @click="sortRatings">
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
      :single-expand="true"
      item-key="name"
      :expanded.sync="expanded"
      show-expand
    >
      <template v-slot:item.rating="{ item }">
        <tr>
          <td v-if="item.rating.scored">
            <rating-score :rating="item.rating" />
          </td>
        </tr>
      </template>
      <template v-slot:expanded-item="{ headers, item }">
        <td class="pa-3" :colspan="headers.length">
          <users-rating-by-pharmacy :ratings="item.ratings" />
        </td>
      </template>
    </v-data-table>
  </div>
</template>

<script>
  import ExportToPdf from '@/components/dashboard/ExportToPdf'
  import UsersRatingByPharmacy from '@/components/dashboard/Graphs/table_parts/UsersRatingByPharmacy'
  import RatingScore from '@/components/dashboard/Graphs/table_parts/RatingScore'
  export default {
    name: 'TableChart',
    components: { RatingScore, UsersRatingByPharmacy, ExportToPdf },
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

        headers: [
          {
            text: 'Аптека',
            value: 'name',
            width: '450',
          },
          {
            text: 'Рейтинг',
            value: 'rating',

          },
          {
            text: 'Конверсия',
            value: 'rating.conversion',
            align: 'end',
          },
          { text: '', value: 'data-table-expand' },
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
        expanded: [],
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
    },
  }
</script>
