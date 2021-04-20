<template>
  <v-simple-table>
    <template v-slot:default>
      <tbody>
        <tr v-for="(rating, index) in ratings" :key="rating.id">
          <td width="15" v-html="index+1" />
          <td width="400" v-html="rating.user.first_name + ' ' + rating.user.last_name" />
          <td><rating-score :rating="rating" /></td>
          <td width="150">
            <conversion :conversion="rating.conversion" />
          </td>
        </tr>
        <tr v-for="(user, index2) in userWithoutRating" :key="index2">
          <td width="15" v-html="ratingsCount + index2" />
          <td width="400" v-html="user.first_name + ' ' + user.last_name" />
          <td>Нет рейтинга</td>
          <td v-html="0.00" />
        </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>
<script>
  import RatingScore from './RatingScore'
  import Conversion from '@/components/dashboard/Graphs/table_parts/Conversion'
  export default {
    name: 'UsersRatingByPharmacy',
    components: {
      Conversion,
      RatingScore,
    },
    props: {
      ratings: {
        type: Array,
      },
      users: {
        type: Array,
        default: () => [],
      },
    },
    computed: {
      userWithoutRating () {
        return this.users.filter(user => {
          const ratingsUserIds = this.ratings.map(rating => rating.user_id)
          return !ratingsUserIds.includes(user.id)
        })
      },
      ratingsCount () {
        return this.ratings.length + 1
      },
    },
  }
</script>
