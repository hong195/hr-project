<template>
  <div class="py-3">
    <h3 class="text-center">
      Информация о чеке
    </h3>
    <v-list v-if="activeCheck" dense>
      <v-list-item v-for="(criteria, index) in activeCheck.criteria" :key="activeCheck.id + index">
        <v-list-item-content>
          <v-list-item-title>
            {{ index + 1 }}. {{ criteria.label }}
          </v-list-item-title>
          <v-row v-if="criteria.use_in_rating" no-gutters>
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
  </div>
</template>
<script>
  export default {
    name: 'ViewCheck',
    props: ['activeCheck'],
  }
</script>
