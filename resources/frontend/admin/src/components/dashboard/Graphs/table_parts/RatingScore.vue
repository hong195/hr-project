<template>
  <div>
    <v-btn
      v-if="rating.id"
      :color="getColor(rating.scored)"
      rounded
      class="rating__btn"
      depressed
      @click="getRating(rating.id)"
    >
      <span style="color: white;">{{ `${rating.scored}/${rating.out_of}` }}</span>
    </v-btn>
    <div v-else>
      Нет Рейтинга
    </div>
    <single-user-rating
      :show-dialog="dialog"
      :rating-id="ratingId"
      @close-dialog="dialog = false"
    />
  </div>
</template>
<script>
  import RatingColor from '@/components/dashboard/mixins/RatingColor'
  import SingleUserRating from '@/views/dashboard/ratings/SingleUserRating'

  export default {
    name: 'RatingScore',
    components: { SingleUserRating },
    mixins: [RatingColor],
    props: {
      rating: {
        required: true,
        type: Object,
      },
    },
    data () {
      return {
        dialog: false,
        ratingId: null,
      }
    },
    methods: {
      getRating (ratingId) {
        this.ratingId = ratingId
        this.dialog = true
      },
    },
  }
</script>
