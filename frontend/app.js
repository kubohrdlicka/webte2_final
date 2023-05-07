import '../resources/js/bootstrap'
import { createApp } from 'vue'

import App from './app/App.vue'
import store from './plugins/store'
import vuetify from './plugins/vuetify'
import router from './plugins/router'
import i18n from './plugins/i18n'
import Toast, { POSITION } from 'vue-toastification';

import * as Mathlive from 'https://unpkg.com/mathlive@0.90.10/dist/mathlive.min.js'
import VueMathfield from "https://unpkg.com/mathlive@0.90.10/dist/vue-mathlive.mjs";
import 'vue-toastification/dist/index.css';

const toastOptions = {
  position: POSITION.BOTTOM_RIGHT,
}


const app = createApp(App)
app.use(i18n)
app.use(store)
app.use(router)
app.use(Toast, toastOptions)
app.use(vuetify)
app.use(Mathlive)
app.use(VueMathfield)

app.mount("#app")

export default app
