import '../resources/js/bootstrap'
import { createApp } from 'vue'

import App from './app/App.vue'
import store from './plugins/store'
import vuetify from './plugins/vuetify'
import router from './plugins/router'
import i18n from './plugins/i18n'

const app = createApp(App)
app.use(i18n)
app.use(store)
app.use(router)
app.use(vuetify)

app.mount("#app")
