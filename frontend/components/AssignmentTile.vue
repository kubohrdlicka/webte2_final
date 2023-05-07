<template>
  <div class="h-wrapper ma-2">
    {{ data }}
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
