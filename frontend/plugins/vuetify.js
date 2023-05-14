import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'

const light_colors = {
  colors: {
    primary: '#b98346',
    secondary: '#c3723c',
  }
}
const dark_colors = {
  colors: {
    primary: '#e3b682',
    secondary: '#f0b289',
  }
}

export default createVuetify({
  components,
  directives,
  theme: {
    themes: {
      light: light_colors,
      dark: dark_colors,
    },
  },
  defaultTheme: localStorage.getItem('theme') || 'light',
})
