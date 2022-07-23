<template>
  <v-app>
    <default-layout v-if="isRouterLoaded">
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </default-layout>
  </v-app>
</template>

<script>
import defaultLayout from './layouts/DefaultLayout'

export default {
  components: {
    defaultLayout
  },
  computed: {
    isRouterLoaded: function() {
      return this.$route.name !== null
    }
  }
}
</script>

<style scoped>

</style>
