<template>
  <div class="py-4">
    <v-card>
      <v-card-title>{{ title }}</v-card-title>
      <v-divider/>
      <div class="d-flex flex-wrap h-limit-max-height">
        <AssignmentTile v-for="item, i in assignments" :key="i"
          :data="item"
          :active="active"
        />
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
    active: {
      type: Boolean,
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
      if(this.active){
        apiService.get('/api/assigments/active').then(Response => {
          this.assignments = Response.data
        })
      }else{
        apiService.get('/api/assigments/pastdue').then(Response => {
          this.assignments = Response.data
        })
      }
    },
  },
  mounted() {
    this.getAssignments()
  },
}
</script>
