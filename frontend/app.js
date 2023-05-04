import '../resources/js/bootstrap'
import { createApp } from 'vue'

import App from './app/App.vue'
import store from './plugins/store'
import vuetify from './plugins/vuetify'
import router from './plugins/router'
import i18n from './plugins/i18n'

import * as Mathlive from 'https://unpkg.com/mathlive@0.90.10/dist/mathlive.min.js'
import VueMathfield from "https://unpkg.com/mathlive@0.90.10/dist/vue-mathlive.mjs";





const app = createApp(App)
app.use(i18n)
app.use(store)
app.use(router)
app.use(vuetify)
app.use(Mathlive)
app.use(VueMathfield)

app.mount("#app")
