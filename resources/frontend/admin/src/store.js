import Vue from 'vue'
import Vuex from 'vuex'
import main from './store_modules/main'
import ui from './store_modules/ui'
// eslint-disable-next-line camelcase
import alert_message from './store_modules/alert_message'
Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    main, ui, alert_message,
  },
})
