<template>
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
</template>

<script>
  import RatingColor from '@/views/dashboard/components/mixins/RatingColor'
  export default {
    name: 'TableChart',
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
  }
</script>
