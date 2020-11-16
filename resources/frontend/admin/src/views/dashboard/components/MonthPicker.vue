<template>
  <v-menu
    ref="menu"
    v-model="menu"
    :close-on-content-click="false"
    :return-value.sync="date"
    transition="scale-transition"
    offset-y
    max-width="290px"
    min-width="290px"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-text-field
        v-model="date"
        label="Месяц, Год"
        hide-details
        prepend-inner-icon="mdi-calendar"
        readonly
        outlined
        v-bind="attrs"
        v-on="on"
      />
    </template>
    <v-date-picker
      v-model.lazy="date"
      type="month"
      :scrollable="false"
    >
      <v-spacer />
      <v-btn
        text
        color="primary"
        @click="menu = false"
      >
        Отмена
      </v-btn>
      <v-btn
        text
        color="primary"
        @click="setDate(date, $refs.menu)"
      >
        Выбрать
      </v-btn>
    </v-date-picker>
  </v-menu>
</template>
<script>
  import moment from 'moment'
  export default {
    name: 'MonthPicker',
    data () {
      return {
        date: null,
        menu: false,
      }
    },
    mounted () {
      this.date = moment().format('YYYY-M')
    },
    methods: {
      setDate (date, dialog) {
        dialog.save(date)
        this.date = date
        const formattedDate = {
          year: moment(this.date ?? null).format('YYYY'),
          month: moment(this.date ?? null).format('M'),
        }
        this.$emit('input', formattedDate)
      },
    },
  }
</script>
