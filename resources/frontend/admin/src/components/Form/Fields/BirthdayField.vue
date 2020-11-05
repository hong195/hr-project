<template>
  <div>
    <h3>{{ label }}</h3>
    <v-row>
      <v-col cols="12" md="4">
        <validation-provider
          v-slot="{ errors }"
          tag="div"
          :rules="validationRule"
          :name="label"
        >
          <v-select v-model="day" name="day" label="День"
                    :items="days"
                    :error-messages="errors"
                    v-bind="attributes"
                    item-text="name"
                    item-value="id"
          />
        </validation-provider>
      </v-col>
      <v-col cols="12" md="4">
        <validation-provider
          v-slot="{ errors }"
          tag="div"
          :rules="validationRule"
          :name="label"
        >
          <v-select v-model="month" name="month" label="Месяц"
                    :items="months"
                    :error-messages="errors"
                    v-bind="attributes"
                    item-text="name"
                    item-value="id"
          />
        </validation-provider>
      </v-col>
      <v-col cols="12" md="4">
        <validation-provider
          v-slot="{ errors }"
          tag="div"
          :rules="validationRule"
          :name="label"
        >
          <v-select v-model="year" name="year" label="Год"
                    :items="years"
                    :error-messages="errors"
                    v-bind="attributes"
                    item-text="name"
                    item-value="id"
          />
        </validation-provider>
      </v-col>
    </v-row>
  </div>
</template>
<script>
  // import SelectField from './SelectField'
  import FieldMixin from '@/components/Form/Mixins/FieldMixin'
  export default {
    name: 'BirthdayField',
    // components: { SelectField },
    mixins: [FieldMixin],
    data () {
      return {
        day: '',
        month: '',
        year: '',
      }
    },
    computed: {

      years () {
        const arr = []
        for (let i = 1950; i <= 2004; i++) arr.push({ id: i, name: i })
        return arr
      },
      days () {
        const arr = []
        for (let i = 1; i <= 31; i++) {
          if (i < 10) {
            arr.push({ id: '0' + i, name: '0' + i })
          } else {
            arr.push({ id: i, name: i })
          }
        }
        return arr
      },
      months () {
        return [
          { id: '01', name: this.$t('january') },
          { id: '02', name: this.$t('february') },
          { id: '03', name: this.$t('march') },
          { id: '04', name: this.$t('april') },
          { id: '05', name: this.$t('may') },
          { id: '06', name: this.$t('june') },
          { id: '07', name: this.$t('july') },
          { id: '08', name: this.$t('august') },
          { id: '09', name: this.$t('september') },
          { id: '10', name: this.$t('october') },
          { id: '11', name: this.$t('november') },
          { id: '12', name: this.$t('december') },
        ]
      },
    },
    watch: {
      year () {
        this.innerValue = this.day + '.' + this.month + '.' + this.year
      },
      month () {
        this.innerValue = this.day + '.' + this.month + '.' + this.year
      },
      day () {
        this.innerValue = this.day + '.' + this.month + '.' + this.year
      },
    },
  }
</script>
