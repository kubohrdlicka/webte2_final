<template>
  <div class="pt-6">
    <div>
      <v-card-title>{{ $t('dashboard.historyAssignment') }}</v-card-title>
    </div>

    <v-card class="d-flex flex-wrap">
      <AssignmentTile v-for="item, i in assignments" :key="i"
        :data="item"
        :active="false"
      />
    </v-card>
  </div>
</template>

<script>
import AssignmentTile from '../components/AssignmentTile.vue';

export default {
  name: 'History view',
  components: {
    AssignmentTile,
  },
  data() {
    return {
      assignments: [
        {title:'caw', description:'idk'},
        {title:'caw', description:'idk'},
        {title:'caw', description:'idk'},
        {title:'caw', description:'idk'},
        {title:'caw', description:'idk'},
        {title:'caw', description:'idk'},
      ],
    }
  },
  methods: {
    async getAssignments() {

    },
  },
  mounted() {
    this.getAssignments()
  },
}
</script>
