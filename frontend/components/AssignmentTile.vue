<template>
  <div class="h-wrapper ma-2">
    {{ data.title }} | {{ data.description }} | {{ data.start }} | {{ data.end }}| {{ store.role }}
    <v-btn color="primary" v-if="store.role === 'student' && active" @click="take()">{{ $t('assignmentTile.take') }}</v-btn>
    <h2 v-if="done">{{ data.points }} / {{data.total_points}}</h2>
  </div>
</template>

<script>
export default {
  name: 'Assignment Tile',
  props: {
    data: {
      type: Object,
      required: true,
    },
    active: {
      type: Boolean,
      required: true,
    },
    done: {
      type: Boolean,
      required: true,
    },
  },
  computed: {
    store() {
      return this.$store.state
    },
  },
  methods: {
    take() {
      this.$router.push({ name: 'assigment-info', params: { id: this.data.id } })
      //redirect to page wehere studend chooses tasks from assigmesnts
      //get from api /api/assigments/info/{id} (id is in props data object)
    }
  }

}
</script>

<style lang="scss" scoped>
.h-wrapper {
  background-color: rgb(var(--v-theme-primary));
  width: 10rem;
  height: 10rem;
}
</style>
