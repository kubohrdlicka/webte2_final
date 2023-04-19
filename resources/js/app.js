import './bootstrap'
import { createApp } from 'vue'

import App from '../../frontend/app/App.vue'
import store from '../../frontend/plugins/store'
import vuetify from '../../frontend/plugins/vuetify'
import router from '../../frontend/plugins/router'
import i18n from '../../frontend/plugins/i18n'

const app = createApp(App)
app.use(store)
app.use(router)
app.use(vuetify)
app.use(i18n)

app.mount("#app")
