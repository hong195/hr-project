<template>
  <validation-provider
    v-slot="{ errors, required, ariaInput, ariaMsg }"
    tag="div"
    :rules="validationRule"
    :name="label"
  >
    <v-text-field
      v-model="innerValue"
      :name="name"
      :error-messages="errors"
      :type="type"
      v-bind="attributes"
      :label="label"
    />
  </validation-provider>
</template>

<script>

  import FieldMixin from '@/components/Form/Mixins/FieldMixin'

  export default {
    name: 'TextField',
    mixins: [FieldMixin],
    props: {
      type: {
        type: String,
        default: 'text',
        validator: (type) => {
          return [
            'text',
            'email',
            'url',
            'tel',
            'search',
            'password',
            'hidden',
            'number'].indexOf(type) !== -1
        },
      },
    },
  }
</script>
