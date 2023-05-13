<template>
  <v-card class="hk-assignment-tile-wrapper ma-3" @click="take()">
    <div class="d-flex justify-center align-center">
      <div v-if="variant === 'active'" class="w-100">
        <div class="d-flex justify-center hk-big-icon-2">
          <v-icon color="primary" class="pa-8">mdi-folder-open-outline</v-icon>
        </div>
        <div class="px-2 hk-asign-title-wrapper">
          <v-divider class="mx-1"/>
          <v-card-title class="pa-0">{{ data.title }}</v-card-title>
          <v-card-subtitle class="pa-0">{{ data.description }}</v-card-subtitle>
          <v-divider class="mx-1 mt-1"/>
        </div>
        <div class="d-flex justify-start align-center pb-2 pl-1" title="Deadline">
          <v-icon size="x-small" color="surface-variant">mdi-clock-outline</v-icon>
          <v-card-subtitle class="px-1 py-1 text-caption">{{ formatDateTime(data.end) }}</v-card-subtitle>
        </div>
        <div class="d-flex justify-end ma-2 pt-4">
          <v-btn color="primary">{{ $t('assignmentTile.take') }}</v-btn>
        </div>
      </div>

      <div v-else-if="variant === 'done'" class="w-100">
        <div class="d-flex justify-center hk-big-icon-2">
          <v-icon color="primary" class="pa-8">mdi-folder-open</v-icon>
        </div>
        <div class="mx-2">
          <v-divider class="mx-1"/>
          <v-card-title class="pa-0 text-primary">{{ data.title }}</v-card-title>
          <v-card-subtitle class="pa-0">{{ data.description }}</v-card-subtitle>
          <v-divider class="mx-1 mt-1"/>
        </div>
        <div class="d-flex justify-end mx-4 my-2">
          <v-card-title class="pa-0">{{ data.points }} / {{data.total_points}}</v-card-title>
        </div>
        <div class="d-flex justify-end ma-2">
          <v-btn variant="outlined" color="primary">{{ $t('assignmentTile.details') }}</v-btn>
        </div>
      </div>

      <div v-else-if="variant === 'pastdue'" class="w-100">
        <div v-if="$store.state.role === 'student'" class="w-100">
          <div class="d-flex justify-center hk-big-icon-2">
            <v-icon color="error" class="pa-8">mdi-timer-lock-outline</v-icon>
          </div>
          <div class="d-flex justify-start align-center pl-2" title="Deadline">
            <v-icon size="x-small" color="error">mdi-clock-outline</v-icon>
            <v-card-subtitle class="px-1 py-1 text-caption text-error">{{ formatDateTime(data.end) }}</v-card-subtitle>
          </div>
          <div class="mx-2">
            <v-divider class="mx-1"/>
            <v-card-title class="pa-0 text-error">{{ data.title }}</v-card-title>
            <v-card-subtitle class="pa-0">{{ data.description }}</v-card-subtitle>
            <v-divider class="mx-1 mt-1"/>
          </div>
          <div class="d-flex justify-end ma-2 pt-6">
            <v-btn variant="outlined">{{ $t('assignmentTile.details') }}</v-btn>
          </div>
        </div>

        <div v-else class="w-100">
          <div class="d-flex justify-center hk-big-icon-2">
            <v-icon class="pa-8">mdi-folder-lock</v-icon>
          </div>
          <div class="mx-2">
            <v-divider class="mx-1"/>
            <v-card-title class="pa-0 text-primary">{{ data.title }}</v-card-title>
            <v-card-subtitle class="pa-0">{{ data.description }}</v-card-subtitle>
            <v-divider class="mx-1 mt-1"/>
          </div>
          <div class="d-flex justify-start align-center pl-2" title="Deadline">
            <v-icon size="x-small">mdi-timer-lock-outline</v-icon>
            <v-card-subtitle class="px-1 py-1 text-caption">{{ formatDateTime(data.end) }}</v-card-subtitle>
          </div>
          <div class="d-flex justify-end ma-2 pt-6">
            <v-btn variant="outlined" color="primary">{{ $t('assignmentTile.details') }}</v-btn>
          </div>
        </div>
      </div>

      <div v-else class="hk-big-icon-2 py-16">
        <v-icon size="large" color="grey-lighten-1">mdi-robot-dead-outline</v-icon>
      </div>
    </div>
  </v-card>

  <!--
  <div class="h-wrapper ma-2">
    {{ data.title }} | {{ data.description }} | {{ data.start }} | {{ data.end }}| {{ store.role }}
    <v-btn color="primary" v-if="store.role === 'student' && variant === 'active'" @click="take()">{{ $t('assignmentTile.take') }}</v-btn>
    <h2 v-if="variant === 'done'">{{ data.points }} / {{data.total_points}}</h2>
  </div>-->
</template>

<script>
export default {
  name: 'Assignment Tile',
  props: {
    data: {
      type: Object,
      required: true,
    },
    variant: {
      type: String, // active, done, pastdue
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
    },
    formatDateTime(input) {
      const date = new Date(input);
      return `${date.toLocaleDateString('sk')} (${date.toLocaleTimeString('sk')})`
    },
  },

}
</script>

<style lang="scss" scoped>
.hk-asign-title-wrapper {
  background-color: rgb(var(--v-theme-primary));
  color: rgb(var(--v-theme-surface));
}
.hk-assignment-tile-wrapper {
  background-color: rgb(var(--v-theme-background));
  border: 3px solid rgb(var(--v-theme-primary));
  border-radius: 1rem;
  width: 12rem;

  button {
    border-radius: 0.6rem;
  }
}
</style>
