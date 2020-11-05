<template>
  <v-snackbar v-model="message" :color="$store.getters.color" :timeout="2000">
    <base-material-alert
      :dismissible="true"
      :color="$store.getters.color"
      class="ma-0"
      dark
    >
      {{ message }}
    </base-material-alert>
  </v-snackbar>
</template>
<script>
  export default {
    name: 'SnackbarMessage',
    data () {
      return {
        timeoutCallback: null,
      }
    },
    computed: {
      message: {
        get () {
          return this.$store.getters.message
        },
        set (val) {
          this.$store.commit('message', val)
        },
      },
      classes () {
        return {
          // eslint-disable-next-line no-undef
          ...VSnackbar.options.computed.classes.call(this),
          'v-snackbar--material': true,
        }
      },
    },
    watch: {
      message (value) {
        const self = this
        if (this.timeoutCallback) {
          clearTimeout(self.timeoutCallback)
        }
        this.timeoutCallback = setTimeout(self.closeSnackbar(), 3000)
      },
    },
    methods: {
      closeSnackbar () {
        this.$store.commit('message', '')
        this.$store.commit('color', '')
      },
    },
  }
</script>
