<template>
  <div class="pt-6">
    <div class="d-md-flex justify-space-between">
      <v-card-title>{{ $t('dashboard.activeAssignment') }}</v-card-title>
      <router-link to="/create-assignment">
        <v-chip outlined round color="primary" @click="{ }" class="mr-3">
          <v-icon small class="mr-2">mdi-plus-thick</v-icon>
          {{ $t('button.createNewAssignment') }}
        </v-chip>
      </router-link>
    </div>

    <v-card class="d-flex flex-wrap">
      <AssignmentTile v-for="item, i in assignments" :key="i"
        :data="item"
        :active="true"
      />
    </v-card>
  </div>
</template>

<script>
import AssignmentTile from '../components/AssignmentTile.vue';

export default {
  name: 'Active Assignment view',
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
