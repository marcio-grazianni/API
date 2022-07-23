<template>
  <div class="d-flex flex-grow-1">
    <v-app-bar app>
      <v-toolbar>
        <v-toolbar-title>Kanban Board</v-toolbar-title>
      </v-toolbar>
    </v-app-bar>

    <v-main>
      <v-container fluid class="fill-height">
        <v-layout>
          <slot></slot>
        </v-layout>
      </v-container>
    </v-main>
  </div>
</template>

<script>
export default {
  data() {
    return {

    }
  }
}
</script>

<style scoped>

</style>
