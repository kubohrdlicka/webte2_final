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
