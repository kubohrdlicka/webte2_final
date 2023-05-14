<template>
  <div class="pt-6">
    <div class="d-md-flex justify-space-between">
      <v-card-title>{{ $t('dashboard.activeAssignment') }}</v-card-title>
      <router-link to="/create-assignment" v-if="$store.state.role === 'teacher' || $store.state.role === 'admin'">
        <v-chip outlined round color="primary" @click="{ }" class="mr-3">
          <v-icon small class="mr-2">mdi-plus-thick</v-icon>
          {{ $t('button.createNewAssignment') }}
        </v-chip>
      </router-link>
    </div>

    <v-card>
      <v-card-subtitle class="pt-4 pb-2">{{ $t('titles.canBeDoneAssignments') }}</v-card-subtitle>
      <div class="d-flex flex-wrap">
        <AssignmentTile v-for="item, i in assignments" :key="i" :data="item" variant="active" />

        <div v-if="!assignments.length" class="d-flex justify-center py-8 w-100">
          <div>
            <div class="d-flex justify-center mb-2 hk-big-icon-2 py-4">
              <v-icon size="large" color="grey-lighten-1">mdi-robot-happy-outline</v-icon>
            </div>
            <div class="d-flex justify-center">
              <v-card-subtitle>{{ $t('titles.noData') }}</v-card-subtitle>
            </div>
          </div>
        </div>
      </div>
    </v-card>
  </div>
</template>

<script>
import AssignmentTile from '../components/AssignmentTile.vue';
import apiService from '../services/apiService';

export default {
  name: 'Active Assignment view',
  components: {
    AssignmentTile,
  },
  data() {
    return {
      assignments: [],
    }
  },
  methods: {
    getAssignments() {
      apiService.get('/api/assigments/active').then(response => {
        this.assignments = response.data
      })
    },
  },
  mounted() {
    this.getAssignments()
  },
}
</script>
