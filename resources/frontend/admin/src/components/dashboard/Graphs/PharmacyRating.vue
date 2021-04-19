<template>
  <v-container>
    <base-material-card
      color="primary"
      icon="mdi-poll-box"
      inline
      class="px-5 py-3 my-10"
    >
      <v-row>
        <v-col>
          <h2 class="mx-3 display-2">
            Рейтинг аптек за {{ formattedDate }}
          </h2>
        </v-col>
        <v-col>
          <month-picker v-model="date" />
        </v-col>
      </v-row>
      <v-tabs v-model="tab" centered>
        <v-tab href="#graph">
          График
        </v-tab>
        <v-tab href="#table">
          Таблица
        </v-tab>
        <v-tabs-items v-model="tab" style="margin-top: 15px;">
          <v-tab-item :value="'graph'">
            <v-progress-linear
              v-if="isLoading"
              indeterminate
              color="primary"
            />
            <bar-chart v-if="date" ref="barChart" :chart-data="chart" />
          </v-tab-item>
          <v-tab-item :value="'table'">
            <table-chart :date="date" :items="items" :is-loading="isLoading" />
          </v-tab-item>
        </v-tabs-items>
      </v-tabs>
    </base-material-card>
  </v-container>
</template>

<script>
  import MonthPicker from '@/components/dashboard/MonthPicker'
  import moment from 'moment'
  import TableChart from '@/components/dashboard/Graphs/TableChart'
  import BarChartMixin from '@/components/dashboard/mixins/BarChartMixin'

  export default {
    name: 'PharmacyRating',
    components: { TableChart, MonthPicker },
    mixins: [BarChartMixin],
    data () {
      return {
        date: {
          year: moment().format('YYYY'),
          month: moment().format('M'),
        },
        items: [],
        tab: 'graph',
        isLoading: true,
      }
    },
    computed: {
      formattedDate () {
        return moment(this.date.month).locale(this.$i18n.locale).format('MMMM')
      },
    },
    watch: {
      date () {
        this.fetchData()
      },
    },
    methods: {
      fetchData () {
        const date = moment(this.date)
        this.isLoading = true
        this.axios.get('pharmacy-rating', {
          params: {
            year: date.format('YYYY'),
            month: date.format('M'),
          },
        })
          .then(({ data }) => {
            this.isLoading = false
            this.items = data.data
            const filteredData = data.data.filter(item => item.rating.scored)
            this.chart.labels = filteredData.map((pharmacy) => ([pharmacy.name]))
            this.chart.datasets[0].data = filteredData.map((pharmacy) => pharmacy.rating.scored)
            this.chart.datasets[0].backgroundColor = this.poolColors(filteredData.length)
            this.$refs.barChart.updateChart()
          }).catch(e => {
            this.isLoading = false
            console.error(e)
          })
      },
    },
  }
</script>
<style >
.v-slide-group__content.v-tabs-bar__content {
  max-width: 250px;
  margin: 0 auto;
}
</style>
