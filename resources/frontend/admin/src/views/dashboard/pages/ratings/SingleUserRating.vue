<template>
  <v-row justify="center">
    <v-dialog
      v-model="showDialog"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
      class="rating-info-wrapper"
    >
      <v-card class="rating-info">
        <v-toolbar
          dark
          color="primary"
        >
          <v-toolbar-title>Информация о рейтинге</v-toolbar-title>
          <v-spacer />
          <v-toolbar-items>
            <v-btn
              icon
              dark
              @click="closeDialog"
            >
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-list
          three-line
          subheader
        >
          <v-row class="main-content">
            <v-col sm="12" xl="3">
              <h3 class="text-center">
                Список чеков
              </h3>
              <v-list>
                <v-select v-model="activeCheckId" :items="checks" item-text="name" item-value="id" />
              </v-list>
            </v-col>
            <v-col sm="12" xl="6">
              <div style="margin: 0 50px;">
                <h3 class="text-center">
                  Информация о чеке
                </h3>
                <view-check :active-check="activeCheck" class="active-check" />
              </div>
            </v-col>
            <v-col sm="12" xl="3">
              <h3 class="text-center">
                Итоговый рейтинг
              </h3>
              <rating-total-info :rating="rating" />
            </v-col>
          </v-row>
        </v-list>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  import moment from 'moment'
  import RatingTotalInfo from './RatingTotalInfo'
  import ViewCheck from '@/views/dashboard/components/ViewCheck'

  export default {
    name: 'SingleUserRating',
    components: {
      RatingTotalInfo,
      ViewCheck,
    },
    props: {
      showDialog: {
        type: Boolean,
        default: false,
      },
      rating: {
        type: Object,
      },
    },
    data: () => ({
      activeCheckId: null,
      checks: [],
    }),
    computed: {
      activeCheck () {
        return this.checks.find((el) => {
          return el.id === this.activeCheckId
        })
      },
    },
    watch: {
      rating: {
        handler () {
          this.fetchRatingsChecks()
        },
      },
    },
    methods: {
      fetchRatingsChecks () {
        this.axios.get('checks', {
          params: {
            ratingId: this.rating.id,
          },
        })
          .then(({ data }) => {
            this.checks = data.data
            this.activeCheckId = this.checks[0].id
          })
      },
      closeDialog () {
        this.$emit('close-dialog')
      },
      formatCreationDate (date, format = 'MMMM YYYY') {
        return moment(date).format(format)
      },
      setActiveCheck (check) {
        this.activeCheck = check
      },
    },
  }
</script>

<style lang="scss">
.rating-info {
  .v-list-item__title {
    font-size: 1.2rem;
    white-space: normal;
  }
  .v-list-item {
    font-size: 1.1rem;
    min-height: 50px !important;
  }
  .main-content {
    padding: 20px;
  }
  .active-check {
    .v-list-item__title {
      font-size: 1.2rem;
      line-height: 1.4rem;
    }
    .v-list {
      margin-top: 10px;
    }
  }
}
</style>
