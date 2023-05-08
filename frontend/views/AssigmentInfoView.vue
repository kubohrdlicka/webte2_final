<template>
    <div class="py-4">
      <v-card>
        <v-card-title>{{ title }}</v-card-title>
        <div class="d-flex flex-wrap h-limit-max-height">
          <ExamTile v-for="item, i in examBundles" :key="i"
            :data="item"
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
        assignment: [],
      }
    },
    methods: {
      async getExamBundles() {
        apiService.get('/api/assigments/info/' + this.$route.params.id).then(Response => {
          this.examBundles = Response.data.exams
          this.assignment = Response.data.assignment
        })
      },
    },
    mounted() {
      this.getExamBundles()
    },
  }
  </script>
  