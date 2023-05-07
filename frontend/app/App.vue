<template>
  <v-app class="h-v-app">
    <!-- <div>App</div> -->
    <RouterView></RouterView>
  </v-app>
</template>

<style lang="scss">
@import '../styles/base.scss';

html {
  overflow-y: auto !important;
}

::-webkit-scrollbar {
  width: 0.7rem;
  background-color: rgb(var(--v-theme-on-surface-variant));
}

::-webkit-scrollbar-thumb {
  background-color: rgb(var(--v-theme-primary));
  border-radius: 0.3rem;
}
</style>