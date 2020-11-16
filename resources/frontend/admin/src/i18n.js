import Vue from 'vue'
import VueI18n from 'vue-i18n'

import ru from 'vuetify/lib/locale/ru'
import en from 'vuetify/lib/locale/en'

Vue.use(VueI18n)

const messages = {
  ru: {
    ...require('@/locales/ar.json'),
    $vuetify: ru,
  },
  en: {
    ...require('@/locales/en.json'),
    $vuetify: en,
  },
}

export default new VueI18n({
  locale: process.env.VUE_APP_I18N_LOCALE || 'en',
  fallbackLocale: process.env.VUE_APP_I18N_FALLBACK_LOCALE || 'en',
  messages,
})
