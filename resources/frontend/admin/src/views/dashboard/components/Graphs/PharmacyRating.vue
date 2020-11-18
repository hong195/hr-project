<template>
  <v-container>
    <base-material-card
      color="primary"
      icon="mdi-poll-box"
      inline
      class="px-5 py-3 mt-6"
    >
      <v-row>
        <v-col md="6">
          <h2 class="mx-3 display-2">
            Рейтинг аптек за {{ formattedDate() }}
          </h2>
        </v-col>
        <v-col md="6">
          <month-picker v-model="date" />
        </v-col>
      </v-row>

      <bar-chart ref="barChart" :chart-data="chart" />
    </base-material-card>
  </v-container>
</template>

<script>
  import MonthPicker from '@/views/dashboard/components/MonthPicker'
  import BarChart from '@/views/dashboard/components/Graphs/BarChart'
  import moment from 'moment'
  import Actions from '@/views/dashboard/components/Actions/PharmacyActions'
  export default {
    name: 'PharmacyRating',
    components: { Actions, BarChart, MonthPicker },
    data () {
      return {
        date: {
          year: moment().format('YYYY'),
          month: moment().format('M'),
        },
        isLoading: false,
        chart: {
          labels: [],
          datasets: [
            {
              backgroundColor: '#2f8cff',
              borderWidth: 1,
              data: [],
            },
          ],
        },

      }
    },
    watch: {
      date () {
        this.fetchData()
      },
    },
    mounted () {
      this.fetchData()
    },
    methods: {
      formattedDate () {
        return moment(this.date.month).locale('ru').format('MMMM')
      },
      dynamicColor () {
        var r = Math.floor(Math.random() * 255)
        var g = Math.floor(Math.random() * 255)
        var b = Math.floor(Math.random() * 255)
        return 'rgba(' + r + ',' + g + ',' + b + ', 0.5)'
      },
      poolColors (a) {
        var pool = []
        for (var i = 0; i < a; i++) {
          pool.push(this.dynamicColor())
        }
        return pool
      },
      fetchData () {
        this.isLoading = true
        this.axios.get('pharmacy-rating', {
          params: {
            year: this.date ? this.date.year : null,
            month: this.date ? this.date.month : null,
          },
        })
          .then(({ data }) => {
            this.isLoading = false
            this.chart.labels = data.labels
            this.chart.datasets[0].data = data.data
            this.chart.datasets[0].backgroundColor = this.poolColors(data.data.length)
            this.$refs.barChart.updateChart()
          }).catch(e => {
            this.isLoading = false
            console.log(e)
          })
      },
    },
  }
</script>
