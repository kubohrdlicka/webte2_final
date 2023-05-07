<template>
  <div class="pt-6">
    <div class="d-flex justify-end">
      <v-card-title class="px-0 text-h4">{{ $t('dashboard.greetingTitle') }}</v-card-title>
    </div>

    <div class="pt-6">
      <div v-if="store.role === 'student'">
        <AssignmentsTab :title="$t('dashboard.activeAssignment')" :active="true"/>
        <AssignmentsTab :title="$t('dashboard.historyAssignment')" :active="false"/>
      </div>

      <v-card v-else-if="store.role === 'teacher'">

      </v-card>

      <v-card v-else-if="store.role === 'admin'">

      </v-card>

      <v-card v-else>
        <v-card-title>{{ $t('dashboard.expiredSession') }}</v-card-title>
        <div class="pa-4">
          <router-link to="/login">
            <v-btn color="primary">{{ $t('login.title') }}</v-btn>
          </router-link>
        </div>
      </v-card>
    </div>
  </div>
</template>

<script>
import AssignmentsTab from './tabs/AssignmentsTab.vue';

export default {
  name: 'Dashboard',
  components: {
    AssignmentsTab,
  },
  computed: {
    store() {
      return this.$store.state
    },
  },
}
</script>