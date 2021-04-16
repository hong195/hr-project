<template>
  <v-simple-table>
    <template v-slot:default>
      <tbody>
        <tr v-for="(rating, index) in ratings" :key="rating.id">
          <td width="15" v-html="index+1" />
          <td v-html="rating.user.first_name + ' ' + rating.user.last_name" />
          <td><rating-score :rating="rating" /></td>
          <td v-html="rating.conversion" />
          <td v-html="formattedDate(rating.updated_at)" />
        </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>
<script>
  import RatingScore from './RatingScore'
  import moment from 'moment'

  export default {
    name: 'UsersRatingByPharmacy',
    components: {
      RatingScore,
    },
    props: {
      ratings: {
        type: Array,
      },
    },
    methods: {
      formattedDate (val) {
        return moment(val).locale(this.$i18n.locale).format('D-MM-YYYY, h:mm:ss')
      },
    },
  }
</script>
