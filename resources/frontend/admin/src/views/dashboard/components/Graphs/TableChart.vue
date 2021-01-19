<template>
  <div>
    <v-data-table
      :items="items"
      :headers="headers"
      :loading="isLoading"
      :sort-by="['rating.scored']"
      :sort-desc="[true]"
    >
      <template v-slot:item.rating="{ item }">
        <tr>
          <td v-if="item.rating">
            <v-btn :color="getColor(item.rating.scored)"
                   rounded
                   class="rating__btn"
                   depressed
                   @click="getRating(item.rating.id)"
            >
              <span style="color: white;">{{ `${item.rating.scored}/${item.rating.out_of}` }}</span>
            </v-btn>
          </td>
          <td v-else>
            Нет Рейтинга
          </td>
        </tr>
      </template>
    </v-data-table>
    <single-user-rating
      :show-dialog="dialog"
      :rating-id="ratingId"
      @close-dialog="dialog = false"
    />
  </div>
</template>

<script>
  import RatingColor from '@/views/dashboard/components/mixins/RatingColor'
  import SingleUserRating from '@/views/dashboard/pages/ratings/SingleUserRating'
  export default {
    name: 'TableChart',
    components: { SingleUserRating },
    mixins: [RatingColor],
    props: {
      items: {
        type: Array,
        default: () => ([]),
      },
      isLoading: {
        type: Boolean,
      },
    },
    data () {
      return {
        dialog: false,
        ratingId: null,
        headers: [
          {
            text: 'Аптека',
            value: 'name',
          },
          {
            text: 'Рейтинг',
            value: 'rating',
          },
        ],
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
