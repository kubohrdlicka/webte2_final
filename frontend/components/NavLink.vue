<template>
  <div>
    <!-- a button link-->
    <div v-if="button !== undefined" @click="$emit('clicked')" class="link">
      <v-list-item
        :prepend-icon="icon"
        active-color="primary"
        :title="title"
      />
    </div>

    <!-- a link link -->
    <a v-else-if="(truelink !== undefined)" :href="link" class="link" target="_blank">
      <v-list-item
        :prepend-icon="icon"
        active-color="primary"
        :title="title"
      />
    </a>

    <!-- a router link -->
    <router-link v-else :to="link" class="link">
      <v-list-item
        :prepend-icon="icon"
        active-color="primary"
        :title="title"
      />
    </router-link>
  </div>
</template>

<script>
export default {
  props: ['link', 'title', 'icon', 'button', 'truelink'],
}
</script>

<style lang="scss" scoped>
.link{
  text-decoration: none;
  cursor: pointer;
  /*:hover {
    background-color: red;
  }*/
}
</style>