<template>
  <div>
    <v-list v-if="activeCheck" dense>
      <v-list-item v-for="(criterion, index) in activeCheck.criteria" :key="index">
        <v-list-item-content v-if="criterion.use_in_rating === 1">
          <v-list-item-title>
            {{ lastIndex(index) }}.
            {{ criterion.label }}
          </v-list-item-title>
          <v-row no-gutters>
            <v-col v-for="(option) in criterion.options" :key="`option-${option.id}`">
              <v-radio-group
                :value="option.selected ? option.label : '1'"
                column
                hide-details
              >
                <v-radio :value="option.label" :label="option.label" readonly disabled />
              </v-radio-group>
              <div v-if="option.description" class="grey--text mb-2 caption ml-2">
                {{ option.description }}
              </div>
            </v-col>
          </v-row>
        </v-list-item-content>
        <v-list-item-content v-else-if="criterion.value">
          <v-list-item-title>
            <h4>Примечание:</h4>
            <v-text-field :value="criterion.value" :disabled="true" />
          </v-list-item-title>
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
        type: [Object, Array],
        default: () => ({}),
      },
    },
    methods: {
      lastIndex (current) {
        return parseInt(current) + 1
      },
    },
  }
</script>
