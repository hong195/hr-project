<template>
  <div>
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
              <div v-if="option.description" class="grey--text mb-2 caption ml-2" style="margin-top: -10px;">
                {{ option.description }}
              </div>
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
    props: {
      activeCheck: {
        type: Object,
        default: () => ({}),
      },
    },
  }
</script>
