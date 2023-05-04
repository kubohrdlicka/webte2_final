<template>
  
    <v-btn variant="plain" icon  @click="toggleTheme">
      <v-icon v-if="theme.global.name.value == 'dark'" icon="mdi-white-balance-sunny"></v-icon> 
      <v-icon v-if="theme.global.name.value == 'light'" icon="mdi-moon-waxing-crescent"></v-icon>
    </v-btn>
  
</template>
  
<script>
import { useTheme } from 'vuetify'

export default {
  setup() {
    const theme = useTheme()


    return {
      theme,
      toggleTheme: () => {
        theme.global.name.value = theme.global.current.value.dark ? 'light' : 'dark'
        localStorage.setItem('theme', theme.global.name.value)
      }
    }
  }
}
</script>
