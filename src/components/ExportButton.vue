<template>
  <v-btn
    rounded
    outlined
    color="success"
    :href="url"
    download
    style="position: fixed;bottom: 100px;right: 100px"
  >Export DB
  </v-btn>
</template>

<script>
export default {
  name: 'ExportButton',
  data() {
    return {
      url: process.env.VUE_APP_API_URL + 'export'
    }
  }
}
</script>

<style scoped>

</style>
