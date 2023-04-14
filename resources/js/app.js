import './bootstrap';
import { createApp } from 'vue'

import App from '../../frontend/app/App.vue'
import store from '../../frontend/plugins/store';
import vuetify from '../../frontend/plugins/vuetify';
import router from '../../frontend/plugins/router';

const app = createApp(App)
app.use(store)
app.use(router)
app.use(vuetify)

app.mount("#app")
