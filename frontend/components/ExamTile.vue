<template>
  <div class="mx-2 my-3 hk-exam-tile-wrapper pa-0 v-col-12 v-col-md-7 v-col-lg-4">
    <div class="d-flex justify-space-between align-center px-4">
      <div class="d-flex align-center">
        <v-icon class="mr-2" color="primary">mdi-file</v-icon>
        <v-card-title v-if="data.title" class="">{{ data.title }}</v-card-title>
        <v-card-subtitle v-else class="">{{ $t('title.noTitle') }}</v-card-subtitle>
      </div>

      <div class="d-flex align-center py-1">
        <div v-if="store.role === 'student' && data.earned_points === undefined" class="d-flex align-center">
          <v-card-subtitle class="pa-0 mr-3">( {{ data.points }} {{ $t('examTile.pointSign') }} )</v-card-subtitle>
          <v-btn v-if="isDoable" color="primary" @click="take()">{{ $t('examTile.take') }}</v-btn>
        </div>
        <v-card-title v-else class="pa-0">{{data.earned_points}} / {{data.points}}</v-card-title>
      </div>
    </div>
  </div>
</template>
  
<script>
export default {
  name: 'Exam Tile',
  data() {
    return {
      isDoable: false,
    }
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
    deadline: {
      required: true,
    }
  },
  computed: {
    store() {
      return this.$store.state
    },
  },
  methods: {
    take() {
      this.$router.push({ name: 'exam', params: { id: this.data.id } })
      //redirect to page wehere studend chooses tasks from assigmesnts
      //get from api /api/assigments/info/{id} (id is in props data object)
    }
  },
  mounted() {
    this.isDoable = (new Date(this.deadline) >= new Date())
    console.log(this.deadline);
  }

}
</script>
  
<style lang="scss" scoped>
.hk-exam-tile-wrapper {
  border: 2px solid rgb(var(--v-theme-surface-variant));
  border-radius: 1rem;
}
</style>
  