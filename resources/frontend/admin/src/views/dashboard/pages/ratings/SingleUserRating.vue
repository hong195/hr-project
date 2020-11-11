<template>
  <v-row justify="center">
    <v-dialog
      v-model="showDialog"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
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
            <v-col md="12" xl="2" offset-md="1" class="mr-auto">
              <h3>Список чеков</h3>
              <v-list>
                <v-select v-model="activeCheckId" :items="checks" item-text="name" item-value="id" />
              </v-list>
            </v-col>
            <v-col md="12" xl="5">
              <h3>Информация о чеке</h3>
              <v-list v-if="activeCheck">
                <v-list-item v-for="(criteria, index) in activeCheck.criteria" :key="activeCheck.id + index">
                  <v-list-item-content>
                    <v-list-item-title>
                      {{ index + 1 }}. {{ criteria.label }}
                    </v-list-item-title>
                    <v-row v-if="criteria.use_in_rating">
                      <v-col v-for="(option) in criteria.options" :key="`option-${option.id}`">
                        <v-radio-group
                          :value="option.selected ? option.label : '1'"
                          column
                        >
                          <v-radio :value="option.label" :label="option.label" readonly disabled />
                        </v-radio-group>
                      </v-col>
                    </v-row>
                    <v-row v-else>
                      <v-col>
                        {{ criteria.value }}
                      </v-col>
                    </v-row>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
            </v-col>
            <v-col md="12" xl="3">
              <h3>Итоговый рейтинг</h3>
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

  export default {
    name: 'SingleUserRating',
    components: {
      RatingTotalInfo,
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
            rating_id: this.rating.id,
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
  }
  .v-list-item {
    font-size: 1.1rem;
    min-height: 50px !important;
  }
  .main-content {
    padding: 20px;
  }
}
</style>
