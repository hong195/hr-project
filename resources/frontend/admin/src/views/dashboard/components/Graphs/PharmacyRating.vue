<template>
  <v-container>
    <base-material-card
      color="primary"
      icon="mdi-poll-box"
      inline
      class="px-5 py-3 mt-6"
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
      <bar-chart v-if="date" ref="barChart" :chart-data="chart" />
    </base-material-card>
  </v-container>
</template>

<script>
  import MonthPicker from '@/views/dashboard/components/MonthPicker'
  import BarChart from '@/views/dashboard/components/Graphs/BarChart'
  import moment from 'moment'

  export default {
    name: 'PharmacyRating',
    components: { BarChart, MonthPicker },
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
    mounted () {
      this.fetchData()
    },
    methods: {
      dynamicColor () {
        const r = Math.floor(Math.random() * 255)
        const g = Math.floor(Math.random() * 255)
        const b = Math.floor(Math.random() * 255)
        return 'rgba(' + r + ',' + g + ',' + b + ', 0.5)'
      },
      poolColors (a) {
        var pool = []
        for (let i = 0; i < a; i++) {
          pool.push(this.dynamicColor())
        }
        return pool
      },
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
            this.chart.labels = data.data.map((pharmacy) => ([pharmacy.name]))
            this.chart.datasets[0].data = data.data.map((pharmacy) => (pharmacy.rating ? pharmacy.rating.scored : 0))
            this.chart.datasets[0].backgroundColor = this.poolColors(data.data.length)
            this.$refs.barChart.updateChart()
          }).catch(e => {
            this.isLoading = false
            console.error(e)
          })
      },
    },
  }
</script>
