<template>
  <div class="pt-6 px-0 d-flex justify-center">
    <div class="v-col-12 px-0">
      <div class="d-flex justify-end">
        <v-card-title class="px-0 text-h4">{{ $t('dashboard.greetingTitle') }}</v-card-title>
      </div>

      <div class="pt-6">
        <div v-if="store.role === 'student'">
          <AssignmentsTab :title="$t('dashboard.activeAssignment')" :active="true" variant="active"/>
          <AssignmentsTab :title="$t('dashboard.doneAssignment')" :active="false" variant="done"/>
          <AssignmentsTab :title="$t('dashboard.historyAssignment')" :active="false" variant="pastdue"/>

        </div>

        <div v-else-if="store.role === 'teacher' || store.role === 'admin'">

          <div class="text-right">
            <router-link to="/create-assignment">
              <v-chip outlined round color="primary" @click="{}" class="mr-3">
                <v-icon small class="mr-2">mdi-plus-thick</v-icon>
                {{ $t('button.createNewAssignment') }}
              </v-chip>
            </router-link>
          </div>

          <AssignmentsTab :title="$t('dashboard.activeAssignment')" variant="active"/>
          <AssignmentsTab :title="$t('dashboard.historyAssignment')" variant="done"/>
        </div>

        <div v-else-if="store.role === 'admin'">


          <AssignmentsTab :title="$t('dashboard.activeAssignment')" variant="active"/>
          <AssignmentsTab :title="$t('dashboard.historyAssignment')" variant="done"/>
        </div>

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