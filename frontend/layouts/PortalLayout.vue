<template>
  <div class="app-holder">
    <v-app-bar app clipped-left dense>
      <v-app-bar-nav-icon color="primary" @click="showNav = !showNav" />
      <v-spacer/>
      <div class="d-flex align-center">
        <ChangeTheme class="mr-2"/>
        <ChangeLanguage class="mr-2"/>
      </div>
      <v-chip outlined color="primary" @click="requestLogout()" class="mr-3">
        <v-icon small class="mr-2">mdi-logout-variant</v-icon>
        {{ $t('navigation.logout') }}
      </v-chip>
    </v-app-bar>

    <v-navigation-drawer app clipped v-model="showNav">
      <v-list>
        <!-- todo role management -->
        <NavLink link="/" :title="$t('navigation.dashboard')" icon="mdi-view-grid" />
        <NavLink link="/" :title="$t('navigation.activeAssignments')" icon="mdi-view-grid" />
        <NavLink link="/" :title="$t('navigation.historyAssignments')" icon="mdi-view-grid" />
        <NavLink link="/" :title="$t('navigation.results')" icon="mdi-view-grid" />
        <NavLink link="/" :title="$t('navigation.adminPortal')" icon="mdi-view-grid" />
        <NavLink link="" :title="$t('navigation.logout')" icon="mdi-logout-variant" button @clicked="requestLogout()" />
      </v-list>
    </v-navigation-drawer>

    <v-main>
      <v-container fluid class="col-xl-7 col-md-10 col-sm-11">
        <router-view></router-view>
      </v-container>
    </v-main>

    <v-footer dense class="d-flex justify-center py-1 bg-primary" app>
      <div class="text-caption">
        QuatroMagoras 2023
      </div>
    </v-footer>

  </div>
</template>

<script>
import NavLink from '../components/NavLink.vue'
import ChangeLanguage from '../components/ChangeLanguage.vue'
import ChangeTheme from '../components/ChangeTheme.vue'

export default {
  components: {
    NavLink,
    ChangeLanguage,
    ChangeTheme,
  },
  data() {
    return {
      showNav: false,
    }
  },
  methods: {
    getUserChipLink() {
      return ''
    },
    getUserChipText() {
      return ''
    }
  },
}
</script>

<style lang="scss" scoped>
v-main {
  min-height: calc(100vh - 64px - 56px); //idk, chat povedal ze su to taketo rozmery a sedi to
}
</style>
