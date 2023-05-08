<template>
  <div class="app-holder">
    <v-app-bar app clipped-left dense>
      <v-app-bar-nav-icon color="primary" @click="showNav = !showNav" />
      <v-spacer/>
      <div class="d-flex align-center">
        <ChangeTheme class="mr-2"/>
        <ChangeLanguage class="mr-2"/>
      </div>
      <v-chip outlined color="primary" @click="logout()" class="mr-3">
        <v-icon small class="mr-2">mdi-logout-variant</v-icon>
        {{ $t('navigation.logout') }}
      </v-chip>
    </v-app-bar>

    <v-navigation-drawer app clipped v-model="showNav">
      <v-list>
        <!-- todo role management -->
        <NavLink link="/" :title="$t('navigation.dashboard')" icon="mdi-view-grid" />
        <NavLink link="/files" :title="$t('navigation.files')" icon="mdi-database" :requireRole="['teacher','admin']" />
        <NavLink link="/assignments" :title="$t('navigation.activeAssignments')" icon="mdi-file-document" />
        <NavLink link="/history" :title="$t('navigation.historyAssignments')" icon="mdi-file-clock" />
        <NavLink link="/results" :title="$t('navigation.results')" icon="mdi-clipboard-file" :requireRole="['teacher','admin']"/>
        <NavLink link="/admin" :title="$t('navigation.adminPortal')" icon="mdi-security" :requireRole="['admin']"/>
      </v-list>
      <v-divider/>
      <v-list>
        <NavLink link="" :title="$t('navigation.logout')" icon="mdi-logout-variant" button @clicked="logout()" />
      </v-list>
    </v-navigation-drawer>

    <v-main>
      <v-container fluid class="col-xl-7 col-md-10 col-sm-11">
        <router-view></router-view>
      </v-container>
    </v-main>

    <div class="d-flex justify-center py-1 bg-primary">
      <div class="text-caption">
        QuatrosMagores &copy; 2023
      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios'
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
    },
    logout() {
      try {
        axios.post(import.meta.env.VITE_URL + '/api/account/logout', {})
          .then(() => {
            sessionStorage.setItem('auth', '')
            sessionStorage.setItem('token', '')
            sessionStorage.setItem('role', '')
            this.$router.push('/login')
          })
      } catch (e) {}
    },
  },
}
</script>

<style lang="scss" scoped>
.v-main {
  min-height: calc(100vh - 28px) !important; //idk, chat povedal ze su to taketo rozmery a sedi to
}
:deep(.v-navigation-drawer) {
  will-change: initial;
}
</style>
