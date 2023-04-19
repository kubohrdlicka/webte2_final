import { createI18n } from "vue-i18n"
import skTranslation from '../i18n/sk.json'
import enTranslation from '../i18n/en.json'

const i18n = createI18n({
  locale: 'sk',
  messages: {
    sk: skTranslation,
    en: enTranslation,
  },
})

export default i18n
