<template>
  <v-simple-table>
    <template v-slot:default>
      <tbody>
        <tr v-for="(rating, index) in ratings" :key="rating.id">
          <td width="15" v-html="index+1" />
          <td width="400" v-html="rating.user.first_name + ' ' + rating.user.last_name" />
          <td><rating-score :rating="rating" /></td>
          <td width="105" v-html="rating.conversion" />
        </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>
<script>
  import RatingScore from './RatingScore'
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
  }
</script>
