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
          <v-select
            v-model="day"
            name="day"
            label="День"
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
          <v-select
            v-model="month"
            name="month"
            label="Месяц"
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
          <v-select
            v-model="year"
            name="year"
            label="Год"
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
  import FieldMixin from '@/components/Form/Mixins/FieldMixin'
  export default {
    name: 'BirthdayField',
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
        for (let i = 1920; i <= 2030; i++) arr.push({ id: i, name: i })
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
          { id: '01', name: 'Январь' },
          { id: '02', name: 'Февраль' },
          { id: '03', name: 'Март' },
          { id: '04', name: 'Апрел' },
          { id: '05', name: 'Май' },
          { id: '06', name: 'Июнь' },
          { id: '07', name: 'Июль' },
          { id: '08', name: 'Август' },
          { id: '09', name: 'Сентябрь' },
          { id: '10', name: 'Октябрь' },
          { id: '11', name: 'Ноябрь' },
          { id: '12', name: 'Декабрь' },
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
    mounted () {
      const self = this
      setTimeout(function () {
        if (self.value) {
          self.day = self.value.slice(0, 2)
          self.month = self.value.slice(3, 5)
          self.year = parseInt(self.value.slice(6, 10))
        }
      }, 1000)
    },
  }
</script>
