<template>
  <div class="py-4">
    <v-card>
      <v-card-title>{{ title }}</v-card-title>
      <v-divider/>
      <div class="d-flex flex-wrap h-limit-max-height">
        <AssignmentTile v-for="item, i in assignments" :key="i"
          :data="item"
          :variant="variant"
        />

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
import AssignmentTile from '../../components/AssignmentTile.vue';
// import apiService from '../../services/apiService';
import apiService from '../../services/apiService';

export default {
  name: 'ActiveAssignmentsTab',
  components: {
    AssignmentTile
  },
  props: {
    variant: {
      type: String,
      required: true,
    },
    title: {
      required: true,
    }
  },
  data() {
    return {
      assignments: [],
    }
  },
  methods: {
    async getAssignments() {
      if(this.variant === 'active'){
        apiService.get('/api/assigments/active').then(Response => {
          this.assignments = Response.data
        })
      }else{
        if(this.variant === 'done'){
          apiService.get('api/assigments/done').then(Response => {
            this.assignments = Response.data
          })
        }else{
          apiService.get('/api/assigments/pastdue').then(Response => {
            this.assignments = Response.data
          })
        }
      }
    },
  },
  mounted() {
    this.getAssignments()
  },
}
</script>
