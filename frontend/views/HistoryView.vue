<template>
  <div class="pt-6">
    <div>
      <v-card-title>{{ $t('dashboard.historyAssignment') }}</v-card-title>
    </div>

    <v-card>
      <v-card-subtitle class="pt-4 pb-2">{{ $t('title.doneAssignments') }}</v-card-subtitle>
      <div class="d-flex flex-wrap">
        <AssignmentTile v-for="item, i in assignmentsDone" :key="i" :data="item" variant='done' />
      </div>

      <v-card-subtitle class="pt-4 pb-2 mt-5">{{ $t('title.pastDueAssignments') }}</v-card-subtitle>
      <div class="d-flex flex-wrap">
        <AssignmentTile v-for="item, i in assignmentsPastDue" :key="i" :data="item" variant='pastdue' />
      </div>
    </v-card>
  </div>
</template>

<script>
import AssignmentTile from '../components/AssignmentTile.vue';
import apiService from '../services/apiService';

export default {
  name: 'History view',
  components: {
    AssignmentTile,
  },
  data() {
    return {
      assignmentsDone: [],
      assignmentsPastDue: [],
    }
  },
  methods: {
    getAssignments() {
      apiService.get('api/assigments/done').then(response => {
        this.assignmentsDone = response.data
      })
      apiService.get('/api/assigments/pastdue').then(response => {
        this.assignmentsPastDue = response.data
      })
    },
  },
  mounted() {
    this.getAssignments()
  },
}
</script>
