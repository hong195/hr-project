<template>
  <v-container>
    <pharmacy-rating />
  </v-container>
</template>

<script>
  import PharmacyRating from '@/views/dashboard/components/Graphs/PharmacyRating'
  export default {
    name: 'DashBoard',
    components: { PharmacyRating },
  }
</script>
