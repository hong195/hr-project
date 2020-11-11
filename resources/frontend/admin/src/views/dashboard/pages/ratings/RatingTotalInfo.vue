<template>
  <v-list>
    <v-list-item>
      <v-list-item-title>
        <v-row>
          <v-col>Дата создания рейтинга:</v-col>
          <v-col class="font-weight-medium">
            {{ formatCreationDate(rating.created_at) }}
          </v-col>
        </v-row>
      </v-list-item-title>
    </v-list-item>
    <v-list-item>
      <v-list-item-title>
        <v-row>
          <v-col>Набранно баллов:</v-col>
          <v-col class="font-weight-medium">
            {{ rating.scored }}
          </v-col>
        </v-row>
      </v-list-item-title>
    </v-list-item>
    <v-list-item>
      <v-list-item-title>
        <v-row>
          <v-col>Максимальное кол-во баллов:</v-col>
          <v-col class="font-weight-medium">
            {{ rating.out_of }}
          </v-col>
        </v-row>
      </v-list-item-title>
    </v-list-item>
  </v-list>
</template>

<script>
  import moment from 'moment'

  export default {
    name: 'RatingTotalInfo',
    props: {
      rating: {
        type: Object,
        default: () => ({}),
      },
    },
    methods: {
      formatCreationDate (date, format = 'MMMM YYYY') {
        return moment(date).format(format)
      },
    },
  }
</script>

<style scoped>

</style>
