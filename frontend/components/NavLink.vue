<template>
  <div>
    <!-- a button link-->
    <div v-if="button !== undefined" @click="$emit('clicked')" class="link">
      <v-list-item  :prepend-icon="icon">
        <v-list-item-content>
          <v-list-item-title v-text="title"></v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </div>

    <!-- a link link -->
    <a v-else-if="(truelink !== undefined)" :href="link" class="link" target="_blank">
      <v-list-item :prepend-icon="icon">
        <v-list-item-content>
          <v-list-item-title v-text="title"></v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </a>

    <!-- a router link -->
    <router-link v-else :to="link" class="link">
      <v-list-item :prepend-icon="icon">
        <v-list-item-content>
          <v-list-item-title v-text="title"></v-list-item-title>
        </v-list-item-content>
      </v-list-item>
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