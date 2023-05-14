<template>
  <div v-if="isVisible">
    <!-- a button link-->
    <div v-if="button !== undefined" @click="$emit('clicked')" class="link">
      <v-list-item
        :prepend-icon="icon"
        :title="title"
      />
    </div>

    <!-- a link link -->
    <a v-else-if="(truelink !== undefined)" :href="link" class="link" target="_blank">
      <v-list-item
        :prepend-icon="icon"
        :title="title"
      />
    </a>

    <!-- a router link -->
    <router-link v-else :to="link" class="link">
      <v-list-item
        :prepend-icon="icon"
        :title="title"
      />
    </router-link>
  </div>
</template>

<script>
export default {
  props: ['link', 'title', 'icon', 'button', 'truelink', 'requireRole'],
  computed: {
    isVisible() {
      const role = this.$store.state.role
      if (this.requireRole) {
        if (this.requireRole.indexOf(role) >= 0) {
          return true
        }
        return false
      }
      return true
    },
  },
}
</script>

<style lang="scss" scoped>
.link{
  text-decoration: none;
  cursor: pointer;
  color: rgb(var(--v-theme-primary)) !important;
  :hover {
    background-color: rgb(var(--v-theme-on-surface-variant));
  }
}

:deep(.v-list-item__content) {
  color: rgb(var(--v-theme-on-surface)) !important;
}
</style>