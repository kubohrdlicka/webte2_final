<template>
  <div class="pt-6">
    <div class="d-md-flex justify-space-between">
      <v-card-title>{{ $t('titles.assignmentOverview') }}</v-card-title>
    </div>

    <v-card class="mx-4 pb-2">
      <div class="d-flex align-center">
        <div class="ml-4 hk-big-icon-2">
          <v-icon color="primary" class="pa-6 mt-1">mdi-folder-open-outline</v-icon>
        </div>
        <div>
          <v-card-title class="text-h5">{{ assignment.title }}</v-card-title>
          <div class="d-flex align-center px-4">
            <v-icon size="small" class="mr-2" color="surface-variant">mdi-clock-outline</v-icon>
            <v-card-subtitle class="px-0">{{ formatDateTime(assignment.end) }}</v-card-subtitle>
          </div>
        </div>
      </div>
      <v-divider class="mt-2 mb-4"/>

      <v-card-title>{{ assignment.description }}</v-card-title>

      <v-card-subtitle>{{ $t('titles.availableExams') }}</v-card-subtitle>

      <div class="mx-2">
        <ExamTile v-for="item, i in examBundles" :key="i"
          :data="item"
          :deadline="assignment.end"
        />
      </div>
    </v-card>
  </div>
</template>
  
  <script>
  import ExamTile from '../components/ExamTile.vue';
  import apiService from '../services/apiService';
  
  export default {
    name: 'ActiveAssignmentsTab',
    components: {
      ExamTile
    },
    props: {
      assignmentsId: {
        type: Number,
        required: true,
      },
      title: {
        required: true,
      }
    },
    data() {
      return {
        examBundles: [],
        assignment: {},
      }
    },
    methods: {
      async getExamBundles() {
        apiService.get('/api/assigments/info/' + this.$route.params.id).then(Response => {
          this.examBundles = Response.data.exams
          this.assignment = Response.data.assignment
        })
      },
      formatDateTime(input) {
        const date = new Date(input)
        return `${date.toLocaleDateString('sk')} (${date.toLocaleTimeString('sk')})`
      }
    },
    mounted() {
      this.getExamBundles()
    },
  }
  </script>
  