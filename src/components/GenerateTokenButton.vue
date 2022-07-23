<template>
  <div class="text-center">
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <template v-slot:activator>
        <v-btn
          rounded
          outlined
          color="success"
          style="position: fixed;bottom: 100px;left: 100px"
          @click="getAccessToken"
        >
          Get Access Token
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="text-h5 justify-center">
          Your access token
        </v-card-title>

        <v-card-text class="text-center">
          <v-card-subtitle>
            {{ token }}
          </v-card-subtitle>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            @click="dialog = false"
          >
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'GenerateTokenButton',
  data() {
    return {
      url: process.env.VUE_APP_API_URL + 'export',
      dialog: false,
      token: ''
    }
  },
  methods: {
    getAccessToken() {
      axios.get('tokens').then((response) => {
        this.token = response.data.token
        this.dialog = true
      })
    }
  }
}
</script>

<style scoped>

</style>
